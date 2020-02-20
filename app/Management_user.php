<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Management_user extends Model
{
    //use Cachable;
    protected $fillable = [
        'username', 'name', 'password','photo','instance_id','user_id'
    ];
}
