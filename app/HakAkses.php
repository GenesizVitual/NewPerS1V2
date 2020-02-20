<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class HakAkses extends Model
{
    //

    protected $table = 'hak_akses';

    protected $fillable= ['admin_bpk_id','instansi_id'];

    public function getInstasi(){
        return $this->belongsTo('App\Instance','instansi_id');
    }
}
