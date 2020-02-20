<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Tiketbantuan as tiket_bantuan;

use Session;

class TiketbantuanController extends Controller
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



    public function index()
    {
        $data_bantuan=tiket_bantuan::where('user_id', Session::get('user_id'))->where('status','1')->get();
        $data_bantuan_selesai=tiket_bantuan::where('user_id', Session::get('user_id'))->where('status','2')->get();
        return view("content2.page_tiketbantuan.index", array('data'=> $data_bantuan,'data_selesai'=>$data_bantuan_selesai));
    }

    public function create()
    {
        return view("content2.page_tiketbantuan.new");
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'department' => 'required',
            'masalah' => 'required',
            'penjel_masalah'=>'required',
            'detail_masalah'=>'required',
        ]);

        $di_tujukn = $req->post('department');
        $masalah = $req->post('masalah');
        $penjelasan = $req->post('penjel_masalah');
        $detail_masalah = $req->post('detail_masalah');

        $model = new tiket_bantuan();
        $model->department = $di_tujukn;
        $model->masalah = $masalah;
        $model->penjelasan = $penjelasan;
        $model->alur_masalah = $detail_masalah;
        $model->user_id = Session::get('user_id');
        $model->status = 1;

        if($model->save())
        {
            $req->session()->flash('message_success', 'Permintaan anda akan diproses');
            return redirect('tiket_bantuan');
        }

        $req->session()->flash('message_fail', 'Mohon Maaf permintaan gagal dikirim');
        return redirect('tiket_bantuan');

    }

    public function detail($id)
    {
        $data = [
          'data_tiket'=> tiket_bantuan::find($id)
        ];

        return view('content2.page_tiketbantuan.detail', $data);
    }
}
