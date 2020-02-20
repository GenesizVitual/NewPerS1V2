<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RegistrasiPelatihanModel extends Model
{
    //

    protected $table='registrasi_pelatihan';

    protected $fillable = [
        'tgl_reg',
        'nm_peserta',
        'alamat',
        'id_prov',
        'id_kab',
        'nama_instansi',
        'email',
        'hp',
        'wa',
        'id_jadwal_pel',
        'id_tgl_pel',
        'kode_kupon',
        'kode_registrasi',
    ];

    public function getProvince(){
        return $this->belongsTo('App\Province','id_prov');
    }
    public function getKab(){
        return $this->belongsTo('App\District','id_kab');
    }

    public function getJadwal(){
        return $this->belongsTo('App\JadwalPelatihanModel','id_jadwal_pel');
    }
    public function getWaktu(){
        return $this->belongsTo('App\WaktuPelModel','id_tgl_pel');
    }
}
