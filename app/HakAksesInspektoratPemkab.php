<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class HakAksesInspektoratPemkab extends Model
{
    //

    protected $table = "hak_akses_inspektorat_pemkab";

    protected $fillable = ['admin_inspektorat_pemkab','instansi_id'];

    public function getInstansi()
    {
        return $this->belongsTo('App\Instance','instansi_id');
    }

}
