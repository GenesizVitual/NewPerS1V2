<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BiayaPelatihanModel extends Model
{
    //
    protected $table = 'biaya_pel';

    protected $fillable = ['id_jadwal_pel','id_waktu_pel','tgl_early_bird','besar_cashback','jumlah_biaya'];

    public function getJadwalPel(){
        return $this->belongsTo('App\JadwalPelatihanModel','id_jadwal_pel');
    }

    public function getwaktuPel(){
        return $this->belongsTo('App\WaktuPelModel','id_waktu_pel');
    }
}
