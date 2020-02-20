<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    //use Cachable;
    protected $table = 'sector';
    public $timestamps =false;
    protected $fillable=['sector_name','user_id'];
}
