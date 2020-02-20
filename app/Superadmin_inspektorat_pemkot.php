<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Superadmin_inspektorat_pemkot extends Model
{
    //use Cachable;
    protected $table = "sp_a_inspektorat_pemkot";

    protected $fillable = ['account','password','province_id','district_id'];

    public function getProvince(){
        return $this->belongsTo('App\Province','province_id');
    }

    public function getDistrict(){
        return $this->belongsTo('App\District', 'district_id');
    }
}
