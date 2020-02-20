<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PrivateAccount as superadmin;

use App\AccountBpk as superadmin_bpk;

use App\Account_inspektorat as superadmin_inspektorat;

use App\Superadmin_inspektorat_pemkot as superadmin_sinpektorat_pemkot;

use Session;

class PrivateAccountController extends Controller
{
    //

    public function index()
    {
      return view('content2.page_login.admin_superuser_login');
    }

    public function login(Request $req)
    {
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $req->username;
        $password = $req->password;

        $check_superAdamin = superadmin::where('username', $username)->where('password',$password)->first();
        $check_superadminBpk = superadmin_bpk::where('account', $username)->where('password',$password)->first();
        $check_superadmin_inspektorat = superadmin_inspektorat::where('account', $username)->where('password',$password)->first();
        $check_superadmin_inspektorat_pemkot = superadmin_sinpektorat_pemkot::where('account', $username)->where('password',$password)->first();

        if(count($check_superAdamin)>0 || !empty($check_superAdamin)){
            $req->session()->put("username", $check_superAdamin->username);
            return redirect('superadminbpk');
        }
        if(count($check_superadminBpk)>0  || !empty($check_superadminBpk)){
            $req->session()->put("nama", $check_superadminBpk->account);
            $req->session()->put('id_admin_bpk', $check_superadminBpk->id);
            return redirect('halama_superadmin_bpk');
        }
        if(count($check_superadmin_inspektorat)>0 || !empty($check_superadmin_inspektorat)){
            $req->session()->put('nama', $check_superadmin_inspektorat->account);
            return redirect('dashboardisnpektorat');
        }

        if(count($check_superadmin_inspektorat_pemkot)>0 || !empty($check_superadmin_inspektorat_pemkot)){
            $req->session()->put('nama', $check_superadmin_inspektorat_pemkot->account);
            return redirect('daftar_admin_inspektorat_pemkot');
        }
    }
}
