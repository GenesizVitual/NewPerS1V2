<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rincian_barang_model extends Model
{
    //
    protected $table='rincian_barang';

    protected $fillable=['id_nota','id_barang','quntitas','satuan','harga_satuan','jumlah_harga','user_id'];

    public function get_barang(){
        return $this->belongsTo('App\Warehouse', 'id_barang');
    }

    public function getNota(){
        return $this->belongsTo('App\Note_receipt','id_nota');
    }


}
