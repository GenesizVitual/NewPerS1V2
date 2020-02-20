<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ref_rek_1 extends Model
{
    //
    protected $table='ref_rek_1';

    public function getKodeRekening2(){
        return $this->hasMany('App\Simda\Ref_rek_2','Kd_Rek_1');
    }
}
