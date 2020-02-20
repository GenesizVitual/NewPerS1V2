<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Tiketbantuan extends Model
{
    //
    //use Cachable;
    protected $table='tiket_bantuan';

    protected $fillable=['department','masalah','penjelasan','alur_masalah','user_id','status'];
}
