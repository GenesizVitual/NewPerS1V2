<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WaktuPelModel extends Model
{
    //

    protected $table='waktu_pel';

    protected $fillable=['id_jadwal_pel','date','date_close'];

    public function get_jadwal_pelatihan(){
        return $this->belongsTo('App\JadwalPelatihanModel','id_jadwal_pel');
    }
}
