<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Belanja extends Model
{
    protected $table='belanja';
    protected $fillable= ['number_belanja','name_belanja','volume','unit','unit_price','total_price','keg_id','user_id'];

    public function getKeg(){
        return $this->belongsTo('App\Keg','keg_id');
    }

    public function getNotaReceipt(){
        return $this->hasMany('App\Note_receipt','belanja_id');
    }
}
