<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Instance extends Model
{

    protected $table="instance";

    protected $fillable=['province_id','district_id','instance','singkatan_instansi','alamat','no_telp','fax','tingkat','logo','user_id'];

    public $timestamps =false;

    public function getProvince()
    {
        return $this->belongsTo('App\Province','province_id');
    }

    public function getDistrict()
    {
        return $this->belongsTo('App\District', 'district_id');
    }

    public function getPengaturanSimda(){
        return $this->hasOne('App\PengaturanSimda','id_instance');
    }
}
