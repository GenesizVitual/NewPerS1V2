<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;
use App\Instance as intasnsi;
use Session;

class aktivasiController extends Controller
{
    //


    public function __construct()
    {
        $this->middleware(function($req, $next){
            if(empty(Session::get('user_id')) || empty(Session::get('id_user_bpk')
                    || empty(Session::get('id_user_inspektorat'))
                    || empty(Session::get('id_user_inspektorat_pemkot'))
                    || empty(Session::get('id_user_inspektorat_pemkab')) ))
            {
                Session::flush();
                return redirect('login#login')->with('message_login_fail','Waktu masuk anda berakhir, Silahkan login Ulang');
            }

            $data_session = Session::all();

            return $next($req);
        });
    }

    public function cek_ativasi(){
        $instace= intasnsi::where('user_id', Session::get('user_id'))->first();
        return view('front_end.page_aktivasi', array('data'=> $instace));
    }

    public function proses_aktivasi(Request $req){
        $this->validate($req,[
            'serial_key'=> 'required'
        ]);
        $aktivasi = intasnsi::where('user_id', Session::get('user_id'))->first();
        if($aktivasi->serial_key == md5($req->serial_key)){
            $aktivasi->status_aktiv = 1;
            $aktivasi->date_aktivasi = date('Y-m-d');
            $aktivasi->save();
            return redirect('/')->with('message_aktivasi','Anda telah berhasil mengaktifkan Persediaan.id anda');
        }else{
            return redirect('/')->with('message_aktivasi','Kode aktifasi yang anda masukan salah ... ');
        }
    }

}
