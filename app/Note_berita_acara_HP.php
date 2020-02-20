<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note_berita_acara_HP extends Model
{
    //

    protected $table='note_berita_acara_hp';

    protected $fillable=['id_nota','nomor_berita_acara','tanggal_berita_acara','tgl_surat_keputusan','user_id'];

    public function getNotaPesanan(){
        return $this->belongsTo('App\Note_receipt','id_nota');
    }
}
