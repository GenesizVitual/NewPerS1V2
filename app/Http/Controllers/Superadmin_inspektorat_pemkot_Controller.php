<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Superadmin_inspektorat_pemkot as inspektorat_pemkot;

use App\Province as provinsi;

use App\District as kabupaten;

use Illuminate\Support\Facades\Hash;

class Superadmin_inspektorat_pemkot_Controller extends Controller
{
    //

    public function index()
    {
        return view('content_inspektorat_pemkot.page_dashboard.dashboard');
    }

    public function login(){
        return view('content2.page_login.super_admin_Inspektorat_pemkot_login');
    }

    public function storelogin(Request $req){
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $req->username;
        $password =$req->password;
        $model = inspektorat_pemkot:: where('account', $username)->first();
        if(count($model)>0){
            if(Hash::check($password, $model->password)){
                $req->session()->put('nama', $model->account);
                $req->session()->put('id_admin_inspektorat_pemkot', $model->id);
                $req->session()->flash("message_success", "Selamat Anda Telah Berhasil Login");
                return redirect('daftarAccountInspektoratPemkot');
            }
        }
        $req->session()->flash("message_fail", "Maaf, anda tidak mempunyai hak akses");
        return redirect('loginSebagaiInspektoratPemkot');
    }

    public function list_data_inspektorat_pemkot(){
        $data = [
            'data' => inspektorat_pemkot::all()
        ];
        return view('content_superadmin.superadminInspektoratpemkot.view', $data);
    }

    public function create(){
        $data = [
            'provinsi'=> provinsi::all(),
            'kabupaten' => kabupaten::all()
        ];
        return view('content_superadmin.superadminInspektoratpemkot.new', $data);
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

        $model = new inspektorat_pemkot();
        $model->account = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->district_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil Dibuat");
            return redirect("superadmininspektoratPemkot");
        }

        $req->session()->flash("message_fail","Account Baru gagal Dibuat");
        return redirect("superadmininspektoratPemkot");
    }

    public function edit($id){
        $data = [
            'data' => inspektorat_pemkot::find($id),
            'provinsi' => provinsi::all(),
            'kabupaten' => kabupaten::all()
        ];

        return view('content_superadmin.superadminInspektoratpemkot.edit', $data);
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

        $model = inspektorat_pemkot::find($id);
        $model->account = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->district_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil Diubah");
            return redirect("superadmininspektoratPemkot");
        }

        $req->session()->flash("message_fail","Account Baru Gagal Dibuat");
        return redirect("superadmininspektoratPemkot");
    }

    public function delete(Request $req, $id){

        $model = inspektorat_pemkot::find($id);
        if($model->delete()){
            $req->session()->flash("message_success","Account Baru Berhasil Dihapus");
            return redirect("superadmininspektoratPemkot");
        }

        $req->session()->flash("message_fail","Account Baru Gagal Dihapus");
        return redirect("superadmininspektoratPemkot");
    }
}
