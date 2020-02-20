<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class typeOfGoods extends Model
{
    //

    protected $table = "typeofgoods";

    public $timestamps =false;

    protected $fillable= ['typeOfGoods','formula','user_id'];

    public function gudang()
    {
        return $this->hasOne('App\Warehouse','typeofgoods_id');
    }
}
