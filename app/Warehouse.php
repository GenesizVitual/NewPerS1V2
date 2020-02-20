<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    //use Cachable;
    protected $table='warehouse';

    protected $fillable=['goods_code','goods_name','unit','specs','brand','minimum_stock','initial_stock','standard_price','typeofgoods_id','total_price','user_id'];

    public function jenis_barang()
    {
        return $this->belongsTo('App\typeOfGoods','typeofgoods_id');
    }

    public function jenis_barang_by_type_goods(){
        return $this->hasOne('App\typeOfGoods','typeofgoods_id');
    }

    public function goodReceipt(){
        return $this->hasOne('App\warehouse_id');
    }

    public function goodMannyReceipt(){
        return $this->hasMany('App\Goodreceipt','warehouse_id');
    }

    public function goodMannyExpenditures(){
        return $this->hasMany('App\Expenditures','warehouse_id');
    }

}
