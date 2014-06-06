<?php

class Analyzer{
	public static function analyze($text, $useLocalLibOnly = false){

		if (is_null($text) || empty($text) ) {
			return '';
		}

		$result = array();

		if(!$useLocalLibOnly){
			$result = static::getServiceResult($text);
		}

		array_push($result, static::getPhpInsightResult($text));
		$avgResult = static::getAverage($result);

		return $avgResult;
	}

	private static function getServiceResult($text){
		$services = Service::all();
		$endpointsResult = array();

		foreach ($services as $service) {
			$call_no = 0;
			$endpoints = $service->endpoints()->get();
			foreach ($endpoints as $ep) {
				array_push($endpointsResult, $ep->call($text));
				$call_no++;
			}   

			$limit = Limit::where('service_id', '=', $service->id)->first();
			$limit->current_hits = $limit->current_hits + $call_no;
			$limit->save();
		}

		return $endpointsResult;
	}

	private static function getPhpInsightResult($text)
	{
		$returnObj = array();
		$sentiment = new Sentiment();

		$scores =$sentiment->score($text);
		$returnObj['likelihood'] = (object)array_change_key_case($scores,CASE_UPPER);
		$returnObj['label'] = strtoupper($sentiment->categorise($text));

		return (object)$returnObj;
	}

	private static function getAverage($resultList){
		$length = count($resultList);
		$sumPos = 0;
		$sumNeu = 0;
		$sumNeg = 0;

		for ($i=0; $i < $length; $i++) { 
			$likelihood = $resultList[$i]->likelihood;

			$sumPos += $likelihood->POS;
			$sumNeu += $likelihood->NEU;
			$sumNeg += $likelihood->NEG;
		}

		$avgPos = $sumPos / $length;
		$avgNeu = $sumNeu / $length;
		$avgNeg = $sumNeg / $length;

		$label = static::getLabel([$avgPos,$avgNeu,$avgNeg]);

		$result = (object)array(
			'POS' => $avgPos,
			'NEU' => $avgNeu,
			'NEG' => $avgNeg,
			'label' => $label
			);

		return $result;
	}

	/**
	* GetLabel
	*Return the result label with highest value
	*/
	private static function getLabel($resultArray){
		$max = max($resultArray);

		if( $max == $resultArray[2] ){
			return"NEG";
		}
		else if( $max ==$resultArray[1] ){
			return "NEU";
		}

		return "POS";
	} 
}