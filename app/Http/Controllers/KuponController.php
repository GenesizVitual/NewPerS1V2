<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use App\KuponModel;
use Illuminate\Http\Request;

use App\JadwalPelatihanModel as jadwal_pel;

use App\WaktuPelModel as waktu_pel;

use App\KuponModel as kupon;

class KuponController extends Controller
{
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
                return redirect('/');
            }

            return $next($req);
        });
    }


    public function index(){
        $data=[
            'data_kupon'=> kupon::all()
        ];
        return view('content_superadmin.kupon.view',$data);
    }

    public function create(){
        $data = [
            'data_jadwalPel'=>jadwal_pel::all(),
            'data_waktuPel'=>waktu_pel::all()
        ];
        return view('content_superadmin.kupon.new', $data);
    }

    public function store(Request $req){
       // dd($req->all());
        $this->validate($req,[
            'pemilik_kupon'=>'required',
            'jadwal_pelatihan' =>'required',
            'waktu_pelatihan' => 'required',
            'bonus_pemilik_kupon' => 'required',
            'bonus_pemilik_kupon2' => 'required',
            'bonus_peserta_kupon'=> 'required',
            'count'=> 'required',
        ]);

        $id_jadwal_pel = $req->jadwal_pelatihan;
        $tgl_pel =  $req->waktu_pelatihan;
        $bonus_pemilik_kupon = $req->bonus_pemilik_kupon;
        $pemilik_kupon = $req->pemilik_kupon;
        $bonus_peserta = $req->bonus_peserta_kupon;
        $bonus_peserta2 = $req->bonus_pemilik_kupon2;
        $count = $req->count;

        if($count != 0 ){
            for ($i=0; $i< $count; $i++){
                $kode_kupon = uniqid();
                $model = new kupon();
                $model->id_jadwal_pel=$id_jadwal_pel;
                $model->id_waktu_pel=$tgl_pel;
                $model->kode_kupon=$kode_kupon;
                $model->pemilik_kupon=$pemilik_kupon;
                $model->bonus_pemilik_kupon=$bonus_pemilik_kupon;
                $model->bonus_pemilik_kupon2=$bonus_peserta2;
                $model->bonus_peserta=$bonus_peserta;
                $model->save();
            }
            $req->session()->flash('message_success', 'Kupon Telah dibuat Baru telah Ditambahkan');
            return redirect('kupon');
        }
        $req->session()->flash('message_fail', 'Jadwal Baru gagal Ditambahkan');
        return redirect('kupon');
    }

    public function filterCoupon(Request $req){
        $this->validate($req,[
            'kupon'=>'required',
        ]);
        $data_coupon = KuponModel::where('kode_kupon', $req->kupon)->first();
        return response()->json($data_coupon);
    }
}
