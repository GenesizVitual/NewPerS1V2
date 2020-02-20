<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\JadwalPelatihanModel as jadwalPelatihan;

use App\WaktuPelModel as waktu_pelatihan;

class WaktuPelController extends Controller
{
    //
    public function index(){
        $data=[
            'data_waktu_pel'=> waktu_pelatihan::all()
        ];
        return view('content_superadmin.waktu_pelatihan.view', $data);
    }

    public function create(){
        $data=[
            'data_jadwalPel'=> jadwalPelatihan::all()
        ];
        return view('content_superadmin.waktu_pelatihan.new', $data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'jadwal_pelatihan'=>'required',
            'tanggal_pelatihan' =>'required',
            'tanggal_berakhir' =>'required',
        ]);

        $jadwal_pelatihan = $req->jadwal_pelatihan;
        $tanggal_pelatihan = date('Y-m-d', strtotime($req->tanggal_pelatihan));
        $tanggal_berakhir = date('Y-m-d', strtotime($req->tanggal_berakhir));

        $model = new waktu_pelatihan();
        $model->id_jadwal_pel=$jadwal_pelatihan;
        $model->date=$tanggal_pelatihan;
        $model->date_close=$tanggal_berakhir;

        if($model->save()){
            $req->session()->flash('message_success', 'Waktu Baru telah Ditambahkan');
            return redirect('waktu_pelatihan');
        }

        $req->session()->flash('message_fail', 'Waktu Baru gagal Ditambahkan');
        return redirect('waktu_pelatihan');
    }

    public function edit($id){
        $data=[
            'data_jadwalPel'=> jadwalPelatihan::all(),
            'data_waktuPel'=>waktu_pelatihan::find($id)
        ];
        return view('content_superadmin.waktu_pelatihan.edit', $data);
    }


    public function update($id,Request $req){
        $this->validate($req,[
            'jadwal_pelatihan'=>'required',
            'tanggal_pelatihan' =>'required',
            'tanggal_berakhir' =>'required',
        ]);

        $jadwal_pelatihan = $req->jadwal_pelatihan;
        $tanggal_pelatihan = date('Y-m-d', strtotime($req->tanggal_pelatihan));
        $tanggal_berakhir = date('Y-m-d', strtotime($req->tanggal_berakhir));


        $model = waktu_pelatihan::find($id);
        $model->id_jadwal_pel=$jadwal_pelatihan;
        $model->date=$tanggal_pelatihan;
        $model->date_close=$tanggal_berakhir;

        if($model->save()){
            $req->session()->flash('message_success', 'Waktu Baru telah Diubah');
            return redirect('waktu_pelatihan');
        }

        $req->session()->flash('message_fail', 'Waktu Baru gagal Diubah');
        return redirect('waktu_pelatihan');
    }


    public function delete($id,Request $req){

        $model = waktu_pelatihan::find($id);
        if($model->delete()){
            $req->session()->flash('message_success', 'Waktu Baru telah Dihapus');
            return redirect('waktu_pelatihan');
        }

        $req->session()->flash('message_fail', 'Waktu Baru gagal Dihapus');
        return redirect('waktu_pelatihan');
    }

    public function get_waktu_pelatihan($id){
        $data= waktu_pelatihan::all()->where('id_jadwal_pel', $id);
        return response()->json($data);
    }
}
