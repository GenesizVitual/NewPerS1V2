<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Fiscal_years extends Model
{
    //
   // use Cachable;
    public $timestamps=false;

    protected $fillable=['years','status','user_id'];
}
