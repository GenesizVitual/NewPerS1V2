<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Seesio;

use App\Account_inspektorat as account;

use App\Province as provinsi;

use App\District as kabupaten;


class AdminInspektoratController extends Controller
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

    public function index(){
        return view('content2.page_login.admin_Inspektorat_login');
    }

    public function login(Request $req)
    {
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required'
        ]);

        $username= $req->username;
        $password = $req->password;
        $model = account::where('account', $username)->first();
        if(count($model) > 0){
            if(Hash::check($password, $model->password)){
                $req->session()->put("id_admin_inspektorat_pemprov", $model->id);
                $req->session()->put("nama", $model->account);
                return redirect('dashboardisnpektorat');
            }else{
                return redirect('loginSebagaiInspektorat');
            }
        }

        return redirect('loginSebagaiInspektorat');
    }

    public function list_superadmin_inspektorat(Request $request)
    {
        $data= [
            'data' => account::all()
        ];
        return view('content_superadmin.superadminInspektorat.view', $data);
    }

    public function create()
    {
        $data=[
            'provinsi' => provinsi::all(),
            'kabupaten' => kabupaten::all()
        ];
        return view('content_superadmin.superadminInspektorat.new', $data);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'username'=> 'required',
            'password'=> 'required|min:5',
            'provinsi'=> 'required',
            'kabupaten'=> 'required'
        ]);

        $username   = $req->username;
        $password   = bcrypt($req->password);
        $provinsi   = $req->provinsi;
        $kabupaten   = $req->kabupaten;

        $model  = new account();
        $model->account        = $username;
        $model->password        = $password;
        $model->province_id        = $provinsi;
        $model->district_id        = $kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success','Superadmin baru berhasil ditambahkan');
            return redirect('superadminspektorat');
        }

        $req->session()->flash('message_fail','Superadmin gagal ditambahkan');
        return redirect('superadminspektorat');

    }

    public function edit($id)
    {
        $pass=[
            'data' => account::find($id),
            'provinsi' => provinsi::all(),
            'kabupaten' => kabupaten::all()
        ];

        return view('content_superadmin.superadminInspektorat.edit', $pass);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'username'=> 'required',
            'password'=> 'required|min:6',
            'provinsi'=> 'required',
            'kabupaten' => 'required'
        ]);

        $username   = $req->username;
        $password   = bcrypt($req->password);
        $provinsi   = $req->provinsi;
        $kabupaten  = $req->kabupaten;

        $model  = account::find($id);
        $model->account        = $username;
        $model->password        = $password;
        $model->province_id     =$provinsi;
        $model->district_id     = $kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success','Superadmin baru berhasil diubah');
            return redirect('superadminspektorat');
        }

        $req->session()->flash('message_fail','Superadmin gagal diubah');
        return redirect('superadminspektorat');

    }

    public function delete(Request $req, $id)
    {
        $model  = account::find($id);

        if($model->delete())
        {
            $req->session()->flash('message_success','Superadmin baru berhasil dihapus');
            return redirect('superadminspektorat');
        }

        $req->session()->flash('message_fail','Superadmin gagal dihapus');
        return redirect('superadminspektorat');

    }
}
