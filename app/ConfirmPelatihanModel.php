<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConfirmPelatihanModel extends Model
{
    //
    protected $table='konfirm_pel';

    protected $fillable = ['kode_registrasi','dari_bank','no_rek_p','bank_tujuan','no_rek_t','tanggal_bayar','jumlah_bayar','bukti'];

    public function getPersertaByKode(){
        return $this->belongsTo('App\RegistrasiPelatihanModel','kode_registrasi','kode_registrasi');
    }
}
