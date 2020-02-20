<?php

namespace App\Http\Controllers;

use App\Mail\EmailRegistrationPelatihan;
use Illuminate\Http\Request;

use App\RegistrasiPelatihanModel as registrasiPelatihanModel;

use Carbon\Carbon;
use Mail;
use App\KuponModel as kupon;

use App\BiayaPelatihanModel as biaya;

class RegisterPelatihanController extends Controller
{
    //



    public function index(){
        $data = [
            'data_registrasi'=> registrasiPelatihanModel::all()
        ];
        return view('content_superadmin.registrasi_dan_konfirmasi.view_registrasi', $data);
    }

    public function daftar(Request $req){
        $this->validate($req,[
            'name'=> 'required',
            'alamat'=>'required',
            'provinsi' => 'required|numeric',
            'kabupaten'=>'required|numeric',
            'nama_instansi'=>'required',
            'email'=>'required',
            'no_hp'=>'required',
            'no_wa'=>'required',
            'id_jadwal_pel'=>'required|numeric',
            'id_tgl_pel'=>'required|numeric',
        ]);


        $nama = $req->name;
        $alamat = $req->alamat;
        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;
        $nama_instansi = $req->nama_instansi;
        $email = $req->email;
        $no_hp = $req->no_hp;
        $no_wa = $req->no_wa;
        $id_jadwal_pel = $req->id_jadwal_pel;
        $id_tgl_pel= $req->id_tgl_pel;
        $tgl_reg = $current = Carbon::now();
        $kupon = $req->kode_kupon;
        $kode_registrasi = uniqid();

        $model = new registrasiPelatihanModel();
        $model->tgl_reg = $tgl_reg;
        $model->nm_peserta = $nama;
        $model->alamat = $alamat;
        $model->id_prov = $provinsi;
        $model->id_kab = $kabupaten;
        $model->nama_instansi = $nama_instansi;
        $model->email = $email;
        $model->hp = $no_hp;
        $model->wa = $no_wa;
        $model->id_jadwal_pel = $id_jadwal_pel;
        $model->id_tgl_pel = $id_tgl_pel;
        $model->kode_kupon = $kupon;
        $model->kode_registrasi = $kode_registrasi;
        $biaya = biaya::all()->where('id_jadwal_pel',$id_jadwal_pel)->where('id_waktu_pel',$id_tgl_pel)->first();
        if($model->save()){
            $data_kupon = "";
            if(!empty($model->kode_kupon)){
                $model_kupon= kupon::where('kode_kupon',$model->kode_kupon)->first();
                $model_kupon->status_kupon ='1';
                $model_kupon->save();
                $data_kupon = $model_kupon;
            }
            $user = [
                'email'=> $email,
                'Nama'=> $model->nm_peserta,
                'Kode_registrasi'=>$model->kode_registrasi,
                'bulan'=>$model->getJadwal->bulan,
                'tanggal'=>$model->getWaktu->date,
                'tempat'=>$model->getJadwal->tempat,
                'kota'=>$model->getKab->district,
                'early_date'=>$biaya->tgl_early_bird,
                'biaya'=>$biaya->jumlah_biaya+($biaya->jumlah_biaya*0.1),
                'kode_kupon'=>$data_kupon
            ];
            Mail::to($req->email)->send(new EmailRegistrationPelatihan($user));
            $req->session()->flash('message_success', 'Info Selanjutnya akan dikirimkan ke email anda');
            return redirect('mendaftar_pelatihan#pelatihan');
        }

        $req->session()->flash('message_fail', 'Ada Kesalahan pada proses input data, Silahkan mencoba ulang ..!!');
        return redirect('mendaftar_pelatihan#pelatihan');
    }


}
