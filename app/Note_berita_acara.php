<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note_berita_acara extends Model
{
    //

    protected $table='note_berita_acara_penerimaan';

    protected $fillable=['id_berita_acara_HP','nomor_berita_acara','nomor_surat_keputusan','tgl_surat_keputusan','tgl_berita_acara','user_id'];

    public function getBeritaAcaraPH(){
        return $this->belongsTo('App\Note_berita_acara_HP','id_berita_acara_HP');
    }
}
