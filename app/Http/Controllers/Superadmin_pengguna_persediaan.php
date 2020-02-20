<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User as pengguna;

class Superadmin_pengguna_persediaan extends Controller
{
    //
    public function index(){

        $data=[
            'pengguna_sudah_konfirmasi'=> pengguna::all()->where('status_verifikasi',1),
            'pengguna_belum_konfirmasi'=> pengguna::all()->where('status_verifikasi',0)
        ];

        return view('content_superadmin.pengguna_persediaan.index', $data);
    }
}
