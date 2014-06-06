<?php

class ApiController extends BaseController {

    // Route: GET /services  //TODO UPDATE
    public function getServices(){ //internal service for AJAX status 

        $response = array();
        $services = Service::all();
        foreach ($services as $service) {
            $endpoints = $service->endpoints()->get();
            $limit = $service->limits()->first();
            $eps = array();
            foreach ($endpoints as $ep) {
                $epArr = $ep->toArray();
                $epArr['paramerters'] = $ep->parameters->toArray();
                $eps[] = $epArr;
            }   
            $response[] = array(
                'name' => $service->name, 
                'root' => $service->root,
                'limit' => $limit->toArray(),
                'endpoints' =>  $eps
            );
        }

        return Response::json($response);
    }

    // Route: GET /doc //TODO UPDATE
    public function getDoc(){
        return Response::json(
            array(
                'URL' => '/analyzer',
                'method' => 'POST',
                'params' => array( 'text' => 'Your text to be analzyed here.{SEP}Use the separating tag that precedes this sentence to split send multiple sentences.'),
                'returns' => array(
                    array(
                        'sentence' => 'Your URL encoded text here.',
                        'likelihood' =>  array(
                            'NEG' => '0.035422791567953',
                            'NEU' => '0.7859424347251',
                            'POS' => '0.17863477370694'
                            ),
                        'label' => 'NEU'
                    ),
                    array(
                        'sentence' => 'Use the separating tag that precedes this sentence to split send multiple sentences.',
                        'likelihood' =>  array(
                            'NEG' => '0.035422791567953',
                            'NEU' => '0.7859424347251',
                            'POS' => '0.17863477370694'
                            ),
                        'label' => 'NEU'
                    )   
                )
            )
        );
    }

    // Route: POST /analyzer
    // @param json_encoded_string query
    public function postAnalyzer(){
        // return "wtf";
        $payload = Input::get('query', 'default');
        if($payload == 'default') return Response::make('you need to give an input', 405);

        // $payload = json_encode(json_decode('{
        //               "keyword": "guns",
        //               "posts": [
        //                 {
        //                   "id": 1,
        //                   "text": "Guns are awesome!",
        //                   "tags": [
        //                     "twitter"
        //                   ]
        //                 },
        //                 {
        //                   "id": 2,
        //                   "text": "Guns don\'t kill people. People do.",
        //                   "tags": [
        //                     "twitter",
        //                     "friends",
        //                     "Iasi"
        //                   ]
        //                 },
        //                 {
        //                   "id": 3,
        //                   "text": "I don\'t own guns.",
        //                   "source": "facebook",
        //                   "tags": [
        //                     "facebook",
        //                     "friends"
        //                   ]
        //                 }
        //               ],
        //               "tools": [
        //                 "all"
        //               ]
        //             }'));
        // dd($payload);
        $response = ResponseBuilder::getAnalyzedResponse($payload);
        return Response::json($response);
    }

    // ASPECTS testing function
    // public function getCallservice(){
    //     $service = Service::where('name', '=', 'nlptools')->first();
    //     $nlptools = $service->endpoints()->where('name','=','api')->first();
    //     return $nlptools->call("cats"); 
    // }

}