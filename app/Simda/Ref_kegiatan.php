<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ref_kegiatan extends Model
{
    //
    protected $table = 'ref_kegiatan';

    public function getMannySubelanjaRinc(){
        return $this->hasMany('App\Simda\Ta_Belanja_Rinc_Sub','Kd_Keg','Kd_Keg');
    }
}
