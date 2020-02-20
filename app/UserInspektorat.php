<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class UserInspektorat extends Model
{
    //use Cachable;
    protected $table='user_disperindak';

    protected $fillable =['username','password','province_id','distric_id'];

    public function getprovinsi(){
        return $this->belongsTo('App\Province','province_id');
    }

    public function getkabupaten(){
        return $this->belongsTo('App\District','distric_id');
    }
}
