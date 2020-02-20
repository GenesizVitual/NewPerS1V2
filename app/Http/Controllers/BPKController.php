<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Session;

use App\HakAkses as hak_akses;

use App\Instance as instansi;

use App\User as pengguna;

class BPKController extends Controller
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
        $instansi = hak_akses::all()->where('admin_bpk_id', Session::get('id_user_bpk'));
        //return response()->json($instansi);
        return view('content_pbpk.page_dashboard.index', array('data_instansi'=> $instansi));
    }

    public function lihat_instansi(Request $req,$id_instansi)
    {
        $model_instansi = instansi::find($id_instansi);
        $mode_pengguna = pengguna::find($model_instansi->user_id);
        $req->session()->put('user_id', $mode_pengguna->id);
        return redirect('halaman_instansi');
    }
}
