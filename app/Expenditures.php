<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Expenditures extends Model
{
    //
   // use Cachable;
    protected $table= 'expenditures';

    protected $fillable=['out_date','goodreceipt_id','warehouse_id','exit_item','sector_id','information','user_id','status_surat_permintaan','	status_surat_pengeluaran'];

    public function get_warehouse(){
        return $this->belongsTo('App\Warehouse','warehouse_id');
    }

    public function get_sector(){
        return $this->belongsTo('App\Sector','sector_id');
    }

    public function get_recept(){
        return $this->belongsTo('App\Goodreceipt', 'goodreceipt_id');
    }
}
