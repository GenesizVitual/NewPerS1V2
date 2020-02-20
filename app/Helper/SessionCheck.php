<?php

namespace App\Helper;

use Illuminate\Http\Request;
use Session;
use Redirect;
use App\Instance;

class SessionCheck
{
    //
    public static function cek_aktivasi($data)
    {
         $instance = Instance::where('user_id', $data['user_id'])->first();
         if($instance->status_aktiv==0){
            return true;
         }else
         {
             return false;
         }
    }

}
