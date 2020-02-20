<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class StockGoods extends Model
{
    //
    //use Cachable;

    protected $table='stock_goods';

    protected $fillable = ['warehouse_id','tgl_akhir_catatan','fiscal_years_id','stock','harga_satuan_stok','user_id'];

    public function getbyYears()
    {
        return $this->belongsTo('App\Fiscal_years','fiscal_years_id');
    }

    public function getGoods()
    {
        return $this->belongsTo('App\Warehouse','warehouse_id');
    }
}
