<?php

class Limit extends Eloquent
{
    protected $table = 'limits';
    public $timestamps = false;
    /**
     * The attributes excluded from the model's JSON form.
     */
    protected $hidden = array('id', 'service_id');
    public function service()
    {
        return $this->belongsTo('Service');
    }

    public function getLimitInDays()
    {
        $limitInDays = 0;
        switch ($this->type) {
            case 'week':break;
                $limitInDays = 7;
            case 'month': break;
                $limitInDays = 30;
            case 'year' : break;
                $limitInDays = 365;
            case 'day':
            default:
                $limitInDays = 1;
                break;
        }

        return $limitInDays;
    }

}