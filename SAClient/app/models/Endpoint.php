<?php

class Endpoint extends Eloquent
{
    protected $table = 'endpoints';
    public $timestamps = false;
    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = array('id', 'updated_at', 'created_at', 'service_id');

    public function service()
    {
        return $this->belongsTo('Service');
    }

    public function parameters()
    {
        return $this->hasMany('Parameter');
    }


    /*
    @param text : string
    */
    public  function call($text)
    {
        $url = $this->service()->first()->root;
        $url .= "/". $this->name."/";
        $params = $this->parameters;
        $pArray = array();
        foreach ($params as $p) {
            if($p->defaultValue)
                $pArray[$p->name] = $p->defaultValue;
        }

        $textParam = $this->parameters()->where('defaultValue','=', 'NULL')->first();
        // $pArray[]
        $pArray[$textParam->name] = $text;

        $response = Unirest::post($url, array( "Accept" => $this->httpHeaders ), $pArray);

            
        $responseObj = json_decode($response->raw_body);

        return $responseObj;
    }

    public function getArgs()
    {
        // $endpoints = this->endpoints()->get();
        // $eps = array();
        // // dd($endpoints->get()[0]); die();
        // foreach ($endpoints as $ep) {
        //     // dd($ep->parameters->toArray()); die();
        //     $epArr = $ep->toArray();
        //     $epArr['paramerters'] = $ep->parameters->toArray();
        //     $eps[] = $epArr;
        // } 
    }
}