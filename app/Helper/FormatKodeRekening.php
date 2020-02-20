<?php

namespace App\Helper;

use Illuminate\Http\Request;

class FormatKodeRekening
{
    //
    public static function kodeRekening($kodeRekening){
        $reNewKodeRekening = $kodeRekening;
        if ($kodeRekening <= 9){
            $reNewKodeRekening= '0'.$kodeRekening;
        }
        return $reNewKodeRekening;
    }

}
