<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Suppliers extends Model
{
    //use Cachable;
    public $timestamps =false;
    protected $fillable = ['suppliers','pimpinan','alamat','no_kontak_supplier','user_id'];
}
