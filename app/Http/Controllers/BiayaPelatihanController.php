<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\JadwalPelatihanModel as jadwal_pelatihan;

use App\BiayaPelatihanModel as biaya_pelatihan_model;

use App\WaktuPelModel as waktu_pelatihan;

class BiayaPelatihanController extends Controller
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


    //
    public function index()
    {
        $data=[
            'data_biaya'=> biaya_pelatihan_model::all()
        ];
        return view('content_superadmin.biaya_pel.view', $data);
    }

    public function create()
    {
        $data=[
            'data_jadwalPel'=> jadwal_pelatihan::all(),
            'waktu_pelatihan' => waktu_pelatihan::all()
        ];
        return view('content_superadmin.biaya_pel.new',$data);
    }



    public function store(Request $req)
    {
        $this->validate($req,[
            'jadwal_pelatihan'=>'required|numeric',
            'tanggal_bayar_duluan' =>'required',
            'waktu_pelatihan' =>'required',
            'besaran_cashback' => 'required|numeric',
            'jumlah_biaya' => 'required|numeric'
        ]);

        $jadwal_pelatihan = $req->jadwal_pelatihan;
        $besaran_cashback = $req->besaran_cashback;
        $jumlah_biaya = $req->jumlah_biaya;
        $tanggal_bayar_duluan = date('Y-m-d', strtotime($req->tanggal_bayar_duluan));
        $waktu_pelatihann = $req->waktu_pelatihan;

        $model = new biaya_pelatihan_model();
        $model->id_jadwal_pel= $jadwal_pelatihan;
        $model->id_waktu_pel= $waktu_pelatihann;
        $model->tgl_early_bird= $tanggal_bayar_duluan;
        $model->besar_cashback= $besaran_cashback;
        $model->jumlah_biaya= $jumlah_biaya;

        if($model->save()){
            $req->session()->flash('message_success', 'Jadwal Baru telah Ditambahkan');
            return redirect('biaya_pel');
        }

        $req->session()->flash('message_fail', 'Jadwal Baru gagal Ditambahkan');
        return redirect('create_biaya_pel');

    }

    public function edit($id)
    {
        $data=[
            'data_jadwalPel'=> jadwal_pelatihan::all(),
            'data'=>biaya_pelatihan_model::find($id),
            'waktu_pelatihan' => waktu_pelatihan::all()
        ];
        return view('content_superadmin.biaya_pel.edit',$data);
    }

    public function update($id,Request $req)
    {
        $this->validate($req,[
            'jadwal_pelatihan'=>'required|numeric',
            'tanggal_bayar_duluan' =>'required',
            'besaran_cashback' => 'required|numeric',
            'jumlah_biaya' => 'required|numeric'
        ]);

        $jadwal_pelatihan = $req->jadwal_pelatihan;
        $besaran_cashback = $req->besaran_cashback;
        $jumlah_biaya = $req->jumlah_biaya;
        $tanggal_bayar_duluan = date('Y-m-d', strtotime($req->tanggal_bayar_duluan));
        $waktu_pelatihann = $req->waktu_pelatihan;

        $model = biaya_pelatihan_model::find($id);
        $model->id_jadwal_pel= $jadwal_pelatihan;
        $model->id_waktu_pel= $waktu_pelatihann;
        $model->tgl_early_bird= $tanggal_bayar_duluan;
        $model->besar_cashback= $besaran_cashback;
        $model->jumlah_biaya= $jumlah_biaya;

        if($model->save()){
            $req->session()->flash('message_success', 'Jadwal Baru telah Diubah');
            return redirect('biaya_pel');
        }

        $req->session()->flash('message_fail', 'Jadwal Baru gagal Diubah');
        return redirect('edit_biaya_pel/'.$id);

    }

    public function delete($id,Request $req)
    {
        $model = biaya_pelatihan_model::find($id);
        if($model->delete()){
            $req->session()->flash('message_success', 'Jadwal Baru telah Dihapus');
            return redirect('biaya_pel');
        }

        $req->session()->flash('message_fail', 'Jadwal Baru gagal Dihapus');
        return redirect('biaya_pel');
    }

    public function getBiayaPelatihan($id,$id2){
        $model = biaya_pelatihan_model::where('id_jadwal_pel', $id)->where('id_waktu_pel',$id2)->first();
        $pass= [
            'biaya_pelatihan'=> number_format($model->jumlah_biaya+($model->jumlah_biaya*0.1),2,',','.'),
            'biaya_cashback'=> number_format($model->besar_cashback,2,',','.'),
            'tgl_early'=> date('d-m-Y', strtotime($model->tgl_early_bird)),
        ];
        return response()->json($pass);
    }
}
