<?php

namespace App\Http\Controllers;

use App\Mail\EmailConfirmasiPelatihan;
use Illuminate\Http\Request;
use Mail;
use App\ConfirmPelatihanModel as konfirmasiPelatihan;


class ConfirmPelatihanController extends Controller
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

    public function index(){
        $data=[
            'data_konfirmasi'=> konfirmasiPelatihan::all()
        ];
        return view('content_superadmin.registrasi_dan_konfirmasi.view_konfirmasi', $data);
    }

    public function pageKonfirmasi($kodeRegistrasi){
        $data=[
            'kode_konfirmasi'=> $kodeRegistrasi
        ];
        return view('front_end.page_konfirmasi',$data);
    }
    public function konfirmasiPelatihan(Request $req)
    {
        $this->validate($req, [
           'kode_registrasi'=>'required',
            'dari_bank'=> 'required',
            'no_rek_p'=>'required|numeric',
            'bank_tujuan'=> 'required',
            'no_rek_t'=> 'required|numeric',
            'tgl_bayar' => 'required',
            'jumlah_bayar' => 'required|numeric',
            'bukti' => 'required|image|mimes:jpeg,png,gif,jpg|max:2048',
        ]);

        $kode_registrasi = $req->kode_registrasi;
        $dari_bank = $req->dari_bank;
        $no_rek_p = $req->no_rek_p;
        $bank_tujuan = $req->bank_tujuan;
        $no_rek_t = $req->no_rek_t;
        $tgl_bayar = date('Y-m-d', strtotime($req->tgl_bayar));
        $jumlah_bayar = $req->jumlah_bayar;
        $bukti_tranfer= $req->bukti;
        $imagename = time(). '.' . $bukti_tranfer->getClientOriginalExtension();

        $modelCOunt = konfirmasiPelatihan::where('kode_registrasi', $kode_registrasi)->count();
        if($modelCOunt > 0){
            $user=[
                'pesan'=>'Konfirmasi Pembayaran Anda Sedang diproses'
            ];
            return redirect('konfirmasi_pelatihan/'.$kode_registrasi);
        }else{
            $model = new konfirmasiPelatihan();
            $model->kode_registrasi = $kode_registrasi;
            $model->dari_bank = $dari_bank;
            $model->no_rek_p = $no_rek_p;
            $model->bank_tujuan = $bank_tujuan;
            $model->no_rek_t = $no_rek_t;
            $model->tanggal_bayar = $tgl_bayar;
            $model->tanggal_bayar = $tgl_bayar;
            $model->jumlah_bayar = $jumlah_bayar;
            $model->bukti = $imagename;
            if($model->save()){
                if($bukti_tranfer->move(public_path('file_rek'), $imagename))
                {
                    $req->session()->flash('message_success', 'Konfirmasi Pembayaran Anda Sedang Kami Proses');
                }else{
                    $req->session()->flash('message_fail','Gagal mengupload bukti tranfer. mohon lakukan konfirmasi ulang');
                }
               return redirect('konfirmasi_pelatihan/'.$kode_registrasi);
           }
        }
    }
}
