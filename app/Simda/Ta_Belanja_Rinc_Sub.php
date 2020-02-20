<?php

namespace App\Simda;

use Illuminate\Database\Eloquent\Model;

class Ta_Belanja_Rinc_Sub extends Model
{
    //
    protected $table='ta_belanja_rinc_sub';

    public function ta_belanja_rinc(){
        return $this->hasMany('App\Simda\Ta_Belanja_Rinc', 'No_Rinc','No_Rinc');
    }

}
