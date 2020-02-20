<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Confirm_langganan extends Model
{
    //
    //use Cachable;
    protected $table='confirm_langganan';

    protected $fillable=['bank_tujuan','bank_pengirim','no_rekening_bank','nama_pengirim','tanggal_pengirim','total_transfer','nama_bukti_rekening','catatan','tagihan_id','user_id'];
}
