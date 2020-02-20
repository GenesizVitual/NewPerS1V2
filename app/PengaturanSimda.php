<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengaturanSimda extends Model
{
    //
    protected $table = "pengeturan_simda";

    protected $fillable = ['Kd_Urusan','Kd_Bidang','Kd_Unit','Kd_Sub','id_instance'];
}
