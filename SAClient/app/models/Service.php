<?php

class Service extends Eloquent
{
    protected $table = 'services';
    public $timestamps = true;
    protected $softDelete = true;
    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = array('created_at', 'updated_at', 'deleted_at');
    
    public function endpoints()
    {
        return $this->hasMany('Endpoint');
    }

    public function limits()
    {
        return $this->hasOne('Limit');
    }

    public function getLimit(){
        return $this->limits->first();
    }
}