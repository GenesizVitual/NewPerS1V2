<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class JadwalPelatihanModel extends Model
{
    //

   // use Cachable;

    protected $table='jadwal_pel';

    protected $fillable=['bulan','id_kab','tempat'];

    public function getDistrict(){
        return $this->belongsTo('App\District','id_kab');
    }

    public function getWaktuPelatihan(){
        return $this->hasOne('App\WaktuPelModel','id');
    }
}
