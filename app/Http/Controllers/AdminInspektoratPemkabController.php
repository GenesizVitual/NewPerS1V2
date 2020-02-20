<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Admin_inspektorat_pemkab as admin_inspektorat;
use App\Superadmin_Inpektorat_pemkab as account_super_admin_pemkab;

use App\Province as provinsi;

use App\District as kabupaten;

use Session;

class AdminInspektoratPemkabController extends Controller
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

    public function getMasterSuperAdminInspektorat()
    {
        $model = account_super_admin_pemkab::find(Session::get('id_user_inspektorat_pemkab'));
        return $model;
    }

    public function index(){
        return view('content_inspektorat_pemkab.page_dashboard.dashboard');
    }

    public function daftarAdminInspektorat(){
        $model = $this->getMasterSuperAdminInspektorat();
        $data=[
            'data'=> admin_inspektorat::all()->where('province_id', $model->province_id)
        ];
        return view('content_inspektorat_pemkab.page_account.index', $data);
    }

    public function create(){
        $data=[
            'provinsi'=> provinsi::all(),
            'kabupaten'=> kabupaten::all()
        ];
        return view('content_inspektorat_pemkab.page_account.new', $data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required'
        ]);

        $username = $req->username;
        $password = bcrypt($req->password);
        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;

        $model = new admin_inspektorat();
        $model->account = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->district_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil dibuat");
            return redirect("daftarAccountInspektoratPemkab");
        }

        $req->session()->flash("message_fail","Account Baru gagal dibuat");
        return redirect("daftarAccountInspektoratPemkab");
    }


    public function edit($id){
        $data=[
            'data'=>admin_inspektorat::find($id),
            'provinsi'=> provinsi::all(),
            'kabupaten'=> kabupaten::all(),
        ];
        return view('content_inspektorat_pemkab.page_account.edit', $data);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required'
        ]);

        $username = $req->username;
        $password = bcrypt($req->password);
        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;

        $model = admin_inspektorat::find($id);
        $model->account = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->district_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil diubah");
            return redirect("daftarAccountInspektoratPemkab");
        }

        $req->session()->flash("message_fail","Account Baru gagal diubah");
        return redirect("daftarAccountInspektoratPemkab");
    }

    public function delete(Request $req, $id){
        $model = admin_inspektorat::find($id);
        if($model->delete()){
            $req->session()->flash("message_success","Account Baru Berhasil Dihapus");
            return redirect("daftarAccountInspektoratPemkab");
        }

        $req->session()->flash("message_fail","Account Baru Gagal Dihapus");
        return redirect("daftarAccountInspektoratPemkab");
    }


}
