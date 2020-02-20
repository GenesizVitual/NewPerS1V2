<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class KuponModel extends Model
{

    protected $table='kupon';

    protected $fillable=['id_jadwal_pel','id_waktu_pel','kode_kupon','bonus_pemilik_kupon','bonus_pemilik_kupon2','status_kupon','pemilik_kupon','bonus_peserta'];

    public function getJadwalPel(){
        return $this->belongsTo('App\JadwalPelatihanModel','id_jadwal_pel');
    }

    public function getWaktuPel(){
        return $this->belongsTo('App\WaktuPelModel','id_waktu_pel');
    }
}
