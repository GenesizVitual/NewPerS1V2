<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Keg extends Model
{
    //use Cachable;
    protected $table = 'keg';
    protected $fillable=['number_keg','keg_name','program_id','user_id','unique_kode'];

    public function getProgram(){
        return $this->hasOne('App\Program', 'program_id');
    }

    public  function getBelanja(){
        return $this->hasOne('App\Belanja','keg_id');
    }

    public  function getSumBelanja(){
        return $this->hasMany('App\Belanja','keg_id');
    }
}
