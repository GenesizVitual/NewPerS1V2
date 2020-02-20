<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ref_rek_5 extends Model
{
    //
    protected $table='ref_rek_5';

    public function getBelongsTRek4(){
        return $this->belongsTo('App\Simda\Ref_rek_4','Kd_Rek_4');
    }
}
