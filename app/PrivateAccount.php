<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class PrivateAccount extends Model
{
    //
   // use Cachable;

    protected $table='privateaccount';

    protected $fillable=["username","code_name","password","level"];
}
