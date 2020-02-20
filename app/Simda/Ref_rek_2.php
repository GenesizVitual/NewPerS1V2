<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ref_rek_2 extends Model
{
    //
    protected $table='ref_rek_2';

    public function getKodeRekening3(){
        return $this->hasMany('App\Simda\Ref_rek_3','Kd_Rek_2');
    }

    public function getBelongsTRek1(){
        return $this->belongsTo('App\Simda\Ref_rek_1','Kd_Rek_1');
    }
}
