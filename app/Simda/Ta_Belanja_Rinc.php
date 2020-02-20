<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ta_Belanja_Rinc extends Model
{
    //
    protected $table = 'ta_belanja_rinc';
    public function get_program(){
        return $this->belongsTo('App\Simda\Ref_Prog','Kd_Prog','KD_Prog');
    }
}
