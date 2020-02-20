<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\District as kabupaten;

use App\JadwalPelatihanModel as jadwal_pelatihan;

class JadwalPelatihanController extends Controller
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



            return $next($req);
        });
    }



    public function index(){
        $data=[
            'data_jadwal'=>jadwal_pelatihan::all()
        ];
        return view('content_superadmin.Jadwal_pelatihan.view', $data);
    }

    public function create(){
        $data= [
            'kabupaten'=> kabupaten::all()
        ];
        return view('content_superadmin.Jadwal_pelatihan.new', $data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'bulan'=>'required',
            'id_kab' =>'required',
            'tempat' => 'required',
       ]);

        $bulan = $req->bulan;
        $id_kab = $req->id_kab;
        $tempat = $req->tempat;

        $model = new jadwal_pelatihan();
        $model->bulan= $bulan;
        $model->id_kab= $id_kab;
        $model->tempat= $tempat;

        if($model->save()){
            $req->session()->flash('message_success', 'Jadwal Baru telah Ditambahkan');
            return redirect('jadwal_pel');
        }

        $req->session()->flash('message_fail', 'Jadwal Baru gagal Ditambahkan');
        return redirect('jadwal_pel');
    }

    public function edit($id){
        $data= [
            'kabupaten'=> kabupaten::all(),
            'data_pelatihan'=> jadwal_pelatihan::find($id)
        ];
        return view('content_superadmin.Jadwal_pelatihan.edit', $data);
    }

    public function update($id,Request $req){
        $this->validate($req,[
            'bulan'=>'required',
            'id_kab' =>'required',
            'tempat' => 'required',
        ]);

        $bulan = $req->bulan;
        $id_kab = $req->id_kab;
        $tempat = $req->tempat;

        $model = jadwal_pelatihan::find($id);
        $model->bulan= $bulan;
        $model->id_kab= $id_kab;
        $model->tempat= $tempat;

        if($model->save()){
            $req->session()->flash('message_success', 'Jadwal Baru telah Diubah');
            return redirect('jadwal_pel');
        }

        $req->session()->flash('message_fail', 'Jadwal Baru gagal Diubah');
        return redirect('jadwal_pel');
    }

    public function delete($id,Request $req){
        $model = jadwal_pelatihan::find($id);
        if($model->delete()){
            $req->session()->flash('message_success', 'jadwal pelatihan ini telah dihapus');
            return redirect('jadwal_pel');
        }
        $req->session()->flash('message_fail', 'jadwal pelatihan ini galgal dihapus');
        return redirect('jadwal_pel');
    }

}
