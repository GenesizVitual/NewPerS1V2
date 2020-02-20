<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Letter_of_request extends Model
{
    //
    //use Cachable;

    protected $table='letter_of_request';

    protected $fillable=['sector_id','no_surat_permintaan','tgl_surat','tgl_cetak','prihal_surat','ditujuan','isi_surat','penutup_surat','pengguna_barang','id_pengeluaran',
        'kepala_bidang','user_id'];

    public function getSector(){
        return $this->belongsTo('App\Sector','sector_id');
    }

    public function get_tujukan(){
        return $this->belongsTo('App\Authorized', 'ditujuan');
    }

    public function get_pengguna_barang(){
        return $this->belongsTo('App\Authorized', 'pengguna_barang');
    }
    public function get_kepala_bidang(){
        return $this->belongsTo('App\Authorized', 'kepala_bidang');
    }
}
