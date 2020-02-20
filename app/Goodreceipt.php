<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class Goodreceipt extends Model
{
    //
    //use Cachable;

    protected $table='goodreceipt';
    protected $fillable= ['dateOfpurchase','warehouse_id','unitPrice','amountOfgoods','nomor_factur','date_factur','suppliers_id','totalPrice','tbk_id','user_id','status','ket','id_rincian_barang'];

    public function getGoods()
    {
        return $this->belongsTo('App\Warehouse','warehouse_id');
    }

    public function getSupplier()
    {
        return $this->belongsTo('App\Suppliers', 'suppliers_id');
    }

    public function getTbk(){
        return $this->belongsTo('App\Tbk','tbk_id');
    }

    public function getExpendures(){
        return $this->hasMany('App\Expenditures','goodreceipt_id');
    }

    public function getExpenduresYear(){
        return $this->belongsTo('App\Expenditures','goodreceipt_id');
    }

    public function getTypeofGoods(){
        return $this->hasMany('App\Warehouse','warehouse_id');
    }

}
