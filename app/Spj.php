<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Spj extends Model
{
    //use Cachable;
    protected $table='spj';
    protected $fillable=['number_spj','user_id'];

    public function getTbk(){
        return $this->hasMany('App\Tbk','spj_id');
    }

    public function getTotalTbk(){
        return $this->hasOne('App\Tbk','spj_id');
    }
}
