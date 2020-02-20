<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\District as kabupaten;

use App\Province as provinsi;

class KabupatenController extends Controller
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
            'data'=>  kabupaten::all()
        ];
        return view('content_superadmin.kabupaten.view', $data);
    }

    public function create()
    {
        $data=[
            'provinsi'=> provinsi::all()
        ];
        return view('content_superadmin.kabupaten.new', $data);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'provinsi' => 'required',
            'kabupaten'=> 'required'
        ]);

        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;
        $model = new kabupaten();
        $model->province_id =  $provinsi;
        $model->district =  $kabupaten;
        if($model->save())
        {
            $req->session()->flash('message_success','Kabupaten baru telah ditambahkan');
            return redirect('kabupaten');
        }

        $req->session()->flash('message_fail','Kabupaten baru gagal ditambahkan');
        return redirect('kabupaten');
    }

    public function edit($id)
    {
        $data = [
            'data'=> kabupaten::find($id),
            'provinsi'=> provinsi::all()
        ];
        return view('content_superadmin.kabupaten.edit', $data);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'provinsi' => 'required',
            'kabupaten'=> 'required'
        ]);

        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;
        $model = kabupaten::find($id);
        $model->province_id =  $provinsi;
        $model->district =  $kabupaten;
        if($model->save())
        {
            $req->session()->flash('message_success','Kabupaten baru telah ditambahkan');
            return redirect('kabupaten');
        }

        $req->session()->flash('message_fail','Kabupaten baru gagal ditambahkan');
        return redirect('kabupaten');
    }

    public function delete(Request $req, $id)
    {
        $model = kabupaten::find($id);
        if($model->delete())
        {
            $req->session()->flash('message_success','Kabupaten baru telah dihapus');
            return redirect('kabupaten');
        }

        $req->session()->flash('message_fail','Kabupaten baru gagal dihapus');
        return redirect('kabupaten');
    }

    public function getKabupaten($id_provinsi){
        $model = kabupaten::where('province_id', $id_provinsi)->get();
        return response()->json($model);
    }
}
