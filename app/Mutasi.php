<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Mutasi extends Model
{
    //
    //use Cachable;
    protected $table = 'mutasi';

    protected $fillable=['tgl_transaksi',
                        'warehouse_id',
                        'goodreceipt_id',
                        'expenditures_id',
                        'last_stock',
                        'jum_in',
                        'jum_out',
                        'remaining_stok',
                        'total_start',
                        'total_final',
                        'total',
                        'user_id'];

    public function getBarang (){
        return $this->belongsTo('App\Warehouse','warehouse_id');
    }

}
