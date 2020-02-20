<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    //use Cachable;
    protected $table="province";

    protected $fillable = ['province'];

    protected $hidden = ['updated_at'];

    public $timestamps = false;

    public function toInstance()
    {
        return $this->belongsTo('App\Instance', 'province_id');
    }
}
