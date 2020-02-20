<?php

namespace App;
use GeneaLabs\LaravelModelCaching\Traits\Cachable;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    //use Cachable;
    protected $table = 'info_langganan';
    protected $fillable=['msg','status_baca','user_id'];

    public function get_user(){
        return $this->belongsTo('App\User', 'user_id');
    }
}
