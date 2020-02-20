<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Authorized extends Model
{
    //
    //use Cachable;
    protected $table="authorized";
    public $timestamps=false;
    protected $fillable=['nama_berwenang', 'nip', 'level', 'user_id'];
}
