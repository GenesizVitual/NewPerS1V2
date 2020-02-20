<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\PaketPrice as paket_tarif;

class TarifPaketController extends Controller
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
                return redirect('/');
            }

            return $next($req);
        });
    }



    public function index(){
        $data = [
            'data' => paket_tarif::all()
        ];
        return view('content_superadmin.tarif_paket.view',$data);
    }

    public function create(){
        return view('content_superadmin.tarif_paket.new');
    }

    public function store(Request $req){
        $this->validate($req,[
            'range' => 'required|numeric',
            'keterangan' => 'required'
        ]);

        $range = $req->range;
        $keterangan = $req->keterangan;

        $model = new paket_tarif();
        $model->range = $range;
        $model->keterangan = $keterangan;

        if($model->save()){
            $req->session()->flash('message_success','Tarif baru berhasil ditambahkan');
            return redirect('tarif');
        }

        $req->session()->flash('message_fail','Tarif baru gagal ditambahkan');
        return redirect('tarif');
    }


    public function edit($id){
        $data = [
            'data' => paket_tarif::find($id)
        ];
        return view('content_superadmin.tarif_paket.edit', $data);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'range' => 'required|numeric',
            'keterangan' => 'required'
        ]);

        $range = $req->range;
        $keterangan = $req->keterangan;

        $model = paket_tarif::find($id);
        $model->range = $range;
        $model->keterangan = $keterangan;

        if($model->save()){
            $req->session()->flash('message_success','Tarif baru berhasil diubah');
            return redirect('tarif');
        }

        $req->session()->flash('message_fail','Tarif baru gagal diubah');
        return redirect('tarif');
    }


    public function delete(Request $req, $id){
        $model = paket_tarif::find($id);
        if($model->delete()){
            $req->session()->flash('message_success','Tarif baru berhasil hapus');
            return redirect('tarif');
        }

        $req->session()->flash('message_fail','Tarif baru gagal hapus');
        return redirect('tarif');
    }
}
