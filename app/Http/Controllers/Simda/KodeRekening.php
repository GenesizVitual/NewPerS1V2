<?php

namespace App\Http\Controllers\Simda;

use App\Helper\SessionCheck;
use App\Simda\Ref_kegiatan;
use App\Simda\Ref_Prog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Simda\Ta_Belanja_Rinc_Sub as Ta_belaja_rinc_sub;
use App\Simda\Ta_Belanja_Rinc as Ta_belaja_rinc;
use App\Simda\Ref_kegiatan as kegitan;
use App\Instance as instance;

use Illuminate\Support\Facades\DB;
use Session;

class KodeRekening extends Controller
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

            if(SessionCheck::cek_aktivasi($data_session)){
                Session::flush();
                return redirect('login#login')->with('message_login_fail','Waktu Aktivasi Anda telah berakhir, Silahkan aktifasi ulang akun anda...!!');
            }

            return $next($req);
        });
    }


    public function index(){

        $data_pengaturan_instance = instance::where('user_id', Session::get('user_id'))->first();
        $data_pengaturan = $data_pengaturan_instance->getPengaturanSimda;
        if(empty($data_pengaturan)){
            return redirect('')->with('message_fail', 'Pengaturan Simda Belum Diisi');
        }

        $data = Ref_Prog::
              where('Kd_Urusan',$data_pengaturan->Kd_Urusan)
            ->where('Kd_Bidang',$data_pengaturan->Kd_Bidang)->get();
//            ->where('Kd_Prog','1')
//            ->where('Kd_Unit','1')
//            ->where('Kd_Rek_1','5')
//            ->where('Kd_Rek_2','2')
//            ->where('Kd_Rek_3','2')
//            ->whereIn('Kd_Rek_4', ['1','6']);
        $data_belanja = Ta_belaja_rinc::where('Kd_Urusan','1');
        $data_keg = Ref_kegiatan::all()->where('Kd_Urusan','1');
         return view('dpa', array('data_prog'=> $data,'data_belanja'=>$data_belanja, 'data_kegiatan'=> $data_keg));
    }

    public function kegiatan(){
        $data = kegitan::all()->where('Kd_Prog',1);
        return $data;
    }

    public function belanja($kd_urusan,$kd_unit,$kd_bidang,$kd_prog,$kd_keg,$kd_rek_1,$kd_rek_2,$kd_rek_3,$kd_rek_4,$kd_rek_5){
        $data = Ta_belaja_rinc::all()->where('Kd_Urusan',$kd_urusan)
            ->where('Kd_Bidang',$kd_bidang)
            ->where('Kd_Prog',$kd_prog)
            ->where('Kd_Unit',$kd_unit)
            ->where('Kd_Keg',$kd_keg)
            ->where('Kd_Rek_1',$kd_rek_1)
            ->where('Kd_Rek_2',$kd_rek_2)
            ->where('Kd_Rek_3',$kd_rek_3)
            ->whereIn('Kd_Rek_4', ['1','6']);

        $data_belanja_rinc = Ta_belaja_rinc_sub::all()->where('Kd_Urusan',$kd_urusan)
            ->where('Kd_Bidang',$kd_bidang)
            ->where('Kd_Prog',$kd_prog)
            ->where('Kd_Unit',$kd_unit)
            ->where('Kd_Keg',$kd_keg)
            ->whereIn('Kd_Rek_4', ['1','6']);

        return view('belanja', array('data_belanja'=> $data, 'data_belanja_sub_rinc'=>$data_belanja_rinc));
    }

}
