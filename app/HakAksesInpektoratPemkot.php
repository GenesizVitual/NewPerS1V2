<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class HakAksesInpektoratPemkot extends Model
{
    //

    protected $table = 'hak_akses_inspektorat_pemkot';

    protected $fillable= ['admin_inspektorat_pemkot','instansi_id'];

    public function getInstasi(){
        return $this->belongsTo('App\Instance','instansi_id');
    }
}
