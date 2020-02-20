<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NoteBeritaAcaraSerahTerimaPekerjaan extends Model
{
    //
    protected $table='note_serah_terima_pekerjaan';

    protected $fillable = ['berita_acara_penerimaan_id','nomor_surat','tanggal_serah_terima','nomor_surat_perintah','tgl_surat_perintah','mengetahui','user_id'];

    public function getBeritaAcara(){
        return $this->belongsTo('App\Note_berita_acara','berita_acara_penerimaan_id');
    }

    public function getAutorized(){
        return $this->belongsTo('App\Authorized','mengetahui');
    }
}
