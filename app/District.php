<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    //
    //use Cachable;
    protected $table="district";

    public $timestamps=false;

    public function toInstance()
    {
        return $this->belongsTo('App\Instance','district_id');
    }

    public function getProvince()
    {
        return $this->belongsTo('App\Province','province_id');
    }
}
