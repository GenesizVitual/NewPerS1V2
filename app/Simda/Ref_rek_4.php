<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ref_rek_4 extends Model
{
    //
    protected $table='ref_rek_4';

    public function getKodeRekening5(){
        return $this->hasMany('App\Simda\Ref_rek_5','Kd_Rek_4');
    }

    public function getBelongsTRek3(){
        return $this->belongsTo('App\Simda\Ref_rek_3','Kd_Rek_3');
    }
}
