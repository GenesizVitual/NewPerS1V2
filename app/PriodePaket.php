<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class PriodePaket extends Model
{
    //
    //use Cachable;

    protected $table = 'priode_paket';

    protected $fillable = ['Periode'];
}
