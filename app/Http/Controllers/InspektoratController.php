<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Session;

use App\hak_akses_diperindak as hak_akses;

use App\HakAksesInpektoratPemkot as hak_akses_pemkot;

use App\Instance as instansi;

use App\User as pengguna;

use App\UserInspektorat as useInspektorat;

class InspektoratController extends Controller
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



    public function index()
    {
        //$modelInspektorat = instansi::where('user_id',Session::get('id_user_inspektorat'))->first();
        $instansi = hak_akses::all()->where('admin_disperindak_id', Session::get('id_user_inspektorat'));
        return view('content_pInspektorat.page_dashboard.index', array('data_instansi'=> $instansi));
    }

    public function lihat_instansi(Request $req,$id_instansi)
    {
        $model_instansi = instansi::find($id_instansi);
        $mode_pengguna = pengguna::find($model_instansi->user_id);
        $req->session()->put('user_id', $mode_pengguna->id);
        $req->session()->put('nama', $mode_pengguna->name);
        return redirect('halaman_instasi_inspetorat');
    }

    public function hakAksespemkot()
    {
        $hak_akses_pemkot = hak_akses_pemkot::all()->where('admin_inspektorat_pemkot', Session::get('id_user_inspektorat_pemkot'));
        return view('content_pInspektorat_pemkot.page_dashboard.index', array('data_instansi'=> $hak_akses_pemkot));
    }

    public function lihat_instansiPemkot(Request $req,$id_instansi)
    {
        $model_instansi = instansi::find($id_instansi);
        $mode_pengguna = pengguna::find($model_instansi->user_id);
        $req->session()->put('user_id', $mode_pengguna->id);
        $req->session()->put('nama', $mode_pengguna->name);
        return redirect('halaman_instasi_inspetorat_pemkot');
    }
}
