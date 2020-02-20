<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Province as provinsi;

class ProvinsiController extends Controller
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
        $data = [
          'data' => provinsi::all()->sortBy('province')
        ];
        return view('content_superadmin.provinsi.view', $data);
    }

    public function create()
    {
        return view('content_superadmin.provinsi.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
           'provinsi' => 'required'
        ]);

        $provinsi = $req->provinsi;
        $model = new provinsi();
        $model->province =  $provinsi;
        if($model->save())
        {
            $req->session()->flash('message_success','Provinsi baru telah ditambahkan');
            return redirect('provinsi');
        }

        $req->session()->flash('message_fail','Provinsi baru gagal ditambahkan');
        return redirect('provinsi');
    }

    public function edit($id)
    {
        $data = [
            'data'=> provinsi::find($id)
        ];
        return view('content_superadmin.provinsi.edit', $data);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'provinsi' => 'required'
        ]);

        $provinsi = $req->provinsi;
        $model = provinsi::find($id);
        $model->province =  $provinsi;
        if($model->save())
        {
            $req->session()->flash('message_success','Provinsi baru telah diubah');
            return redirect('provinsi');
        }

        $req->session()->flash('message_fail','Provinsi baru gagal diubah');
        return redirect('provinsi');
    }

    public function delete(Request $req, $id)
    {
        $model = provinsi::find($id);
        if($model->delete())
        {
            $req->session()->flash('message_success','Provinsi baru telah dihapus');
            return redirect('provinsi');
        }

        $req->session()->flash('message_fail','Provinsi baru gagal dihapus');
        return redirect('provinsi');
    }

}
