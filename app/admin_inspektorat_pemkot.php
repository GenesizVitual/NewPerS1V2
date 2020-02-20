<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class admin_inspektorat_pemkot extends Model
{
    //
    //use Cachable;
    protected $table = "admin_inspektorat_pemkot";

    protected $fillable = ["username","	password","province_id","distric_id"];

    public function getProvince(){
        return $this->belongsTo('App\Province','province_id');
    }

    public function getdistrict(){
        return $this->belongsTo('App\District','distric_id');
    }
}
