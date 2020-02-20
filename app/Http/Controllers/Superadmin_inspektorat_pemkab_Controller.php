<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Superadmin_Inpektorat_pemkab as inspektorat_pemkab;

use App\Province as provinsi;

use App\District as kabupaten;

use Illuminate\Support\Facades\Hash;

class Superadmin_inspektorat_pemkab_Controller extends Controller
{
    //
    public function index(){
        $data = [
            'data' => inspektorat_pemkab::all()
        ];
        return view('content_superadmin.superadminInspektoratpemkab.view', $data);
    }

    public function login(){
        return view('content2.page_login.super_admin_Inspektorat_pemkab_login');
    }

    public function storelogin(Request $req){
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $req->username;
        $password =$req->password;
        $model = inspektorat_pemkab:: where('account', $username)->first();
        if(count($model)>0)
        {
            if(Hash::check($password, $model->password)){
                $req->session()->put('nama', $model->account);
                $req->session()->put('id_user_inspektorat_pemkab', $model->id);

                return redirect('daftarAccountInspektoratPemkab');
            }
            $req->session()->flash('message_fail','Password anda salah');
            return redirect('loginSebagaiInspektoratPemKab');
        }
        $req->session()->flash("message_fail", "Maaf, anda tidak mempunyai hak akses");
        return redirect('loginSebagaiInspektoratPemKab');
    }

    public function create(){
        $data=[
            'provinsi'=> provinsi::all(),
            'kabupaten'=> kabupaten::all()
        ];
        return view('content_superadmin.superadminInspektoratpemkab.new', $data);
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

        $model = new inspektorat_pemkab();
        $model->account = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->district_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil Dibuat");
            return redirect("superadmininspektoratPemkab");
        }

        $req->session()->flash("message_fail","Account Baru gagal Dibuat");
        return redirect("superadmininspektoratPemkab");
    }

    public function edit($id){
        $data=[
            'data'=> inspektorat_pemkab::find($id),
            'provinsi'=> provinsi::all(),
            'kabupaten'=> kabupaten::all()
        ];
        return view('content_superadmin.superadminInspektoratpemkab.edit', $data);
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

        $model = inspektorat_pemkab::find($id);
        $model->account = $username;
        $model->password = $password;
        $model->province_id = $provinsi;
        $model->district_id = $kabupaten;

        if($model->save()){
            $req->session()->flash("message_success","Account Baru Berhasil Diubah");
            return redirect("superadmininspektoratPemkab");
        }

        $req->session()->flash("message_fail","Account Baru gagal Diubah");
        return redirect("superadmininspektoratPemkab");
    }

    public function delete(Request $req, $id){
        $model = inspektorat_pemkab::find($id);
        if($model->delete()){
            $req->session()->flash("message_success","Account Baru Berhasil Dihapus");
            return redirect("superadmininspektoratPemkab");
        }
        $req->session()->flash("message_fail","Account Baru gagal Dihapus");
        return redirect("superadmininspektoratPemkab");
    }
}
