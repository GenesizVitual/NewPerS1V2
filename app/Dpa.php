<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;

class Dpa extends Model
{
    //
    //use Cachable;
    protected $table='dpa_pagu';

    protected $fillable = ['pagu_value', 'fiscal_years_id', 'user_id'];


    public function get_thnAnggaran(){
        return $this->belongsTo('App\Fiscal_years', 'fiscal_years_id');
    }

    public function getDPADariProgram(){
        return $this->hasOne('App\Program','id');
    }
}
