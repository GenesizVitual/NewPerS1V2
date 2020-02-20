<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Tbk extends Model
{
    //
    //use Cachable;
    protected $table = 'tbk';
    protected $fillable=['number_tbk','spj_id','user_id'];

    public function getSPJ(){
        return $this->hasOne('App\SPJ', 'spj_id');
    }

    public  function getGoodReciept(){
        return $this->hasOne('App\Goodreceipt','tbk_id');
    }

    public  function getSumReciept(){
        return $this->hasMany('App\Goodreceipt','tbk_id');
    }
}
