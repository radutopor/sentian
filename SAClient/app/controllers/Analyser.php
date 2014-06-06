<?php

class Analyser extends BaseController
{
	public function analyse()
	{
		$query = Input::get('q');
		
		$analysisData = new stdClass();
		$analysisData->keyword = $query;
		$analysisData->posts = array();
		$analysisData->tools = array('all');
		
		$postsRetrievers = array(new FacebookPostsRetriever, new TwitterPostsRetriever);
		foreach($postsRetrievers as $postsRetriever)
		{
			$posts = $postsRetriever->retrieve($query, null);
			$analysisData->posts = array_merge($analysisData->posts, $posts);
		}
		
		$analysisDataJSON = json_encode($analysisData);
		
//        $response = Unirest::post("http://service/analyzer",
//			array( "Accept" => "application/json" ),
//			array('query' => $analysisDataJSON)
//        );
		$request = Request::create('/service/analyzer', 'POST', array('query' => $analysisDataJSON));
		Request::replace($request->input());
		$response = Route::dispatch($request)->getContent();

//		$analysisResult = json_decode($response->raw_body);
		$analysisResult = json_decode($response);

		foreach($analysisResult->posts as $post){
			foreach($analysisData->posts as $postData){
				if($postData['id'] == $post->id)
				{
					$post->data = $postData;
					break;
				}
			}
		}
		
		return View::make('AnalysisResult')->with('analysisResult', $analysisResult);
	}
}