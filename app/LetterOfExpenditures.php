<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;
class LetterOfExpenditures extends Model
{
    //use Cachable;

    protected $table='letter_of_expenditures';
    protected $fillable = ['sector_id','no_surat_pengeluaran','tgl_surat_keluar','prihal','ditujukan','isi_surat','penutup_surat','pengguna_barang','id_pengeluaran','tgl_cetak','user_id'];

    public function getSector(){
        return $this->belongsTo('App\Sector','sector_id');
    }

    public function get_tujukan(){
        return $this->belongsTo('App\Authorized', 'ditujukan');
    }

    public function get_pengguna_barang(){
        return $this->belongsTo('App\Authorized', 'pengguna_barang');
    }
    public function get_kepala_bidang(){
        return $this->belongsTo('App\Authorized', 'kepala_bidang');
    }

    public function get_penyimpan_barang(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
