<?php

namespace App;

use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class Program extends Model
{
    //use Cachable;
    protected $table='program';
    protected $fillable=['account_code','program_name','dpa_id','fiscal_years_id','user_id'];

    public function getKeg(){
        return $this->hasMany('App\Keg','program_id');
    }

    public function getTotalActivities(){
        return $this->hasOne('App\Activities','program_id');
    }
	
	 public function get_thnAnggaran(){
        return $this->belongsTo('App\Fiscal_years', 'fiscal_years_id');
    } 
	public function getDpa(){
        return $this->hasOne('App\Dpa', 'dpa_id');
    }
}
