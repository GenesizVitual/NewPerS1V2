<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
class User extends Authenticatable
{
    use Notifiable;
    //use Cachable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'nip', 'email', 'password', 'telp', 'province_id', 'distric_id','remember_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getDistrict(){
        return $this->belongsTo('App\District','distric_id');
    }
    public function getProvince(){
        return $this->belongsTo('App\Province','province_id');
    }
    public function getInstansi(){
        return $this->hasOne('App\Instance','user_id');
    }
}
