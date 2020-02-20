<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class PaketPrice extends Model
{
    //use Cachable;

    protected $table ='paket_price';

    protected $fillable=['range','keterangan'];
}
