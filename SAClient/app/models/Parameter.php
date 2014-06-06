<?php

class Parameter extends Eloquent
{
    protected $table = 'parameters';
    public $timestamps = false;
    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = array('endpoint_id', 'created_at', 'updated_at');

    public function endpoint()
    {
        return $this->belongsTo('Endpoint');
    }

}