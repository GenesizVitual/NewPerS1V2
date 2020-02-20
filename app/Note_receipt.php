<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note_receipt extends Model
{
    protected $table = 'note_receipt';
    protected $fillable = ['nomor_surat',
        'belanja_id',
        'supplier_id',
        'pengguna_anggaran',
        'tanggal_selesai_pekerjaan',
        'syarat_syarat_pekerjaan',
        'tgl_awal_pekerjaan',
        'instansi_id',
        'user_id'
    ];

    public function get_supplier(){
        return $this->belongsTo('App\Suppliers','supplier_id');
    }

    public function get_berwenang(){
        return $this->belongsTo('App\Authorized','pengguna_anggaran');
    }

    public function get_belanja(){
        return $this->belongsTo('App\Belanja','belanja_id');
    }

    public function get_instansi(){
        return $this->belongsTo('App\Instance','instansi_id');
    }

    public function getRincianBelanja(){
        return $this->hasMany('App\Rincian_barang_model','id_nota');
    }

}
