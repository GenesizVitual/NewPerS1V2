<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ref_rek_3 extends Model
{
    //
    protected $table='ref_rek_3';

    public function getKodeRekening4(){
        return $this->hasMany('App\Simda\Ref_rek_4','Kd_Rek_3');
    }

    public function getBelongsTRek2(){
        return $this->belongsTo('App\Simda\Ref_rek_2','Kd_Rek_2');
    }
}
