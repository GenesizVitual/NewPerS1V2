<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class hak_akses_diperindak extends Model
{
    //

    protected $table = 'hak_akses_disperindak';

    protected $fillable= ['admin_disperindak_id','instansi_id'];

    public function getInstasi(){
        return $this->belongsTo('App\Instance','instansi_id');
    }
}
