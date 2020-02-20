<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\HakAksesInspektoratPemkab as hak_akses;

use App\Instance as instansi;

use App\User as pengguna;

use Session;

class InspektoratPemkabController extends Controller
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


    public function halaman()
    {
        $instansi = hak_akses::all()->where('admin_inspektorat_pemkab', Session::get('id_user_inspektorat_pemkab'));
        return view('content_pInspektorat_pemkab.page_dashboard.index', array('data_instansi'=> $instansi));
    }

    public function hakAksespemkot()
    {
        $hak_akses_pemkot = hak_akses_pemkot::all()->where('admin_inspektorat_pemkab', Session::get('id_user_inspektorat_pemkab'));
        return view('content_pInspektorat_pemkot.page_dashboard.index', array('data_instansi'=> $hak_akses_pemkot));
    }

    public function lihat_instansiPemkab(Request $req,$id_instansi)
    {
        $model_instansi = instansi::find($id_instansi);
        $mode_pengguna = pengguna::find($model_instansi->user_id);
        $req->session()->put('user_id', $mode_pengguna->id);
        $req->session()->put('nama', $mode_pengguna->name);
        return redirect('halaman_inspektorat_pemkab');
    }
}
