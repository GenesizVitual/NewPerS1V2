<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\admin_inspektorat_pemkot as admin_ins_pemkot;

use App\Province as provinsi;

use App\District as kabupaten;

use App\Superadmin_inspektorat_pemkot as account_super_admin_pemkot;

use Illuminate\Support\Facades\Hash;

use Session;

class AdminInspektoratPemkotController extends Controller
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
        $model = account_super_admin_pemkot::find(Session::get('id_admin_inspektorat_pemkot'));
        return $model;
    }

    public function index(){
        $master_id = $this->getMasterSuperAdminInspektorat();
        $data = [
            'data' => admin_ins_pemkot::where('province_id', $master_id->province_id)->get()
        ];
        return view('content_inspektorat_pemkot.page_account.index', $data);
    }

    public function create(){
        $data = [
            'provinsi' => provinsi::all(),
            'kabupaten' => kabupaten::all()
        ];

        return view('content_inspektorat_pemkot.page_account.new', $data);
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

        $model = new admin_ins_pemkot();
        $model->username = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->distric_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil dibuat");
            return redirect("daftarAccountInspektoratPemkot");
        }

        $req->session()->flash("message_fail","Account Baru gagal dibuat");
        return redirect("daftarAccountInspektoratPemkot");
    }

    public function edit($id){
        $data = [
            'data' => admin_ins_pemkot::find($id),
            'provinsi' => provinsi::all(),
            'kabupaten' => kabupaten::all()
        ];

        return view('content_inspektorat_pemkot.page_account.edit', $data);
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

        $model = admin_ins_pemkot::find($id);
        $model->username = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->distric_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil diubah");
            return redirect("daftarAccountInspektoratPemkot");
        }

        $req->session()->flash("message_fail","Account Baru gagal diubah");
        return redirect("daftarAccountInspektoratPemkot");
    }

    public function delete(Request $req, $id){
       $model = admin_ins_pemkot::find($id);

        if($model->delete()){
            $req->session()->flash("message_success","Account Baru Berhasil dihapus");
            return redirect("daftarAccountInspektoratPemkot");
        }
        $req->session()->flash("message_fail","Account Baru gagal dihapus");
        return redirect("daftarAccountInspektoratPemkot");
    }
}
