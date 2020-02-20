<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use App\Mail\EmailVerifications;
use Illuminate\Http\Request;


use Auth;

use Illuminate\Support\Facades\Hash;
use Mockery\Exception;

use Session;

use Mail;


use App\Mail\UserVerifications;

use Redirect;

use App\AccountBpk as account_bpk;

use App\Province as provinsi;

use App\District as kabupaten;

use App\User as user;

use App\Instance as instansi;

use App\UserBpk as userBpk;

use App\Langganan as langganan;

use Carbon\Carbon;

use App\Goodreceipt as penerimaan;

use App\UserInspektorat as inspektorat;

use App\admin_inspektorat_pemkot as inspektorat_pemkot;
use App\Admin_inspektorat_pemkab as inspektorat_pemkab;

class RegisterController extends Controller
{

    public function index()
    {
        return "Hello Github";
    }

    public function Login()
    {
        $pass=
            [
                'provinsi'=> provinsi::all(),
                'kabupaten'=> kabupaten::all()
            ];

        return view('content2.page_login.login_penyimpan_barang', $pass);
    }

    public function Signup()
    {   $pass=
        [
            'provinsi'=> provinsi::all(),
            'kabupaten'=> kabupaten::all()
        ];
        return view('content2.page_login.signup_page', $pass);
    }

    public function ganti_password(){
        return view('front_end.lupa-password');
    }

    public function shadow_password(Request $req){
        $this->validate($req, [
            'email' => 'required|email'
        ]);

        $email = $req->email;
        $shadow_password = str_random(6);
        $user = [
            'email'=> $email,
            'password'=>$shadow_password
        ];
        $model = user::where('email', $email)->first();
        $model->password = bcrypt($shadow_password);
        if($model->save()){
            $req->session()->flash('message_success', 'Silahkan Buka email anda untuk melihat password baru anda');
            Mail::to($req->email)->send(new EmailVerifications($user));
            return redirect('login');
        }
        $req->session()->flash('message_fail', 'Password Gagal dibuatkan');
        return redirect('login');
    }

    public function StoreAccount(Request $req)
    {
        $this->validate($req, [
           'name' => 'required',
           'nip' => 'required',
           'email' => 'required|email',
           'password' => 'required|min:5',
           'no_hp' => 'required',
           'provinsi' => 'required|numeric',
           'kabupaten' => 'required|numeric',
           'nama_skpd' => 'required',
            'accepted' => 'required'
        ]);


        $name = $req->name;
        $nip= $req->nip;
        $email = $req->email;
        $password = bcrypt($req->password);
        $no_hp= $req->no_hp;
        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;
        $nama_skpd = $req->nama_skpd;
        $token = str_random(40);


        if($this->cekEmail($email) > 0)
        {
            $req->session()->flash('message_fail', 'Maaf email anda sudah terdaftar..!');
            return redirect('register#register');
        }

        $user = new user([
            'name'      => $name,
            'nip'      => $nip,
            'email'     => $email,
            'password'  => $password,
            'no_hp'  => $no_hp,
            'province_id'  => $provinsi,
            'distric_id'  => $kabupaten,
            'remember_token' => $token
        ]);


        try{
            if($user->save()){

                $instansi = new instansi();
                $instansi->province_id = $req->provinsi;
                $instansi->district_id =$req->kabupaten;
                $instansi->instance = $nama_skpd;
                $instansi->user_id = $user->id;
                $instansi->save();
                Mail::to($req->email)->send(new UserVerifications($user));

                $req->session()->flash('message_success', 'Selamat registrasi anda berhasil, Silahkan Buka email anda untuk memverifikasi akun persediaan.id di folder inbox/spam');
                return redirect('login#login');
            }
        }catch (Exception $e){
            $req->session()->flash('message_fail', 'Akun Anda gagal dibuat');
            return redirect('register#register');
        }

        $req->session()->flash('message_fail', 'Akun Anda gagal dibuat');
        return redirect('register#register');

    }

    public function StoreLogin(Request $req)
    {

        $this->validate($req,[
            'name' => 'required',
            'password' => 'required|min:5'
        ]);

        $name = $req->name;
        $password = $req->password;

        $user = user::where('name', $name)->where('status_verifikasi','1')->get();

        if(count($user) > 0)
        {
            $req->session()->put('status_aktif', 'true');
			
			if(Hash::check($password, $user[0]->password)){
                $req->session()->put('user_id', $user[0]->id);
                $req->session()->put('nama', $user[0]->name);
                $penerimaan_model = penerimaan::all()->where('user_id', $user[0]->id)->count('id');
				$req->session()->flash('message_success','Selamat Datang di Aplikasi Manajemen Persediaan');
             	return redirect('dashboard');
            }else{
                $req->session()->flash('message_fail','Anda tidak mempunyai hak akses pada aplikasi ini, email atau password salah');
                return redirect('login#login');
            }
        }

        $req->session()->flash('message_fail','Anda tidak mempunyai hak akses pada aplikasi ini, , email atau password salah');
        return redirect('login#login');
    }

    public function loginBpk()
    {
        $pass=
            [
                'provinsi'=> provinsi::all(),
                'kabupaten'=> kabupaten::all()
            ];
        return view('content2.page_login.bpk_login', $pass);
    }

    public function loginInspektorat()
    {
        $pass=
            [
                'provinsi'=> provinsi::all(),
                'kabupaten'=> kabupaten::all()
            ];
        return view('content2.page_login.inspektorat_login', $pass);
    }

    public function loginadminbpk()
    {
        return view('content2.page_login.admin_bpk_login');
    }

    public function loginsuperadminbpk(Request $req)
    {
        $this->validate($req, [
            'username' => 'required',
            'password' => 'required'
        ]);

        $username = $req->username;
        $password = $req->password;

        $model =account_bpk::where('account', $username)->first();
        if(count($model->account) >0){
            if(Hash::check($password, $model->password)){
                $req->session()->put('id_admin_bpk', $model->id);
                $req->session()->put('nama', $model->account);
                return redirect('halama_superadmin_bpk');
            }else{
                return redirect('login_admin_bpk');
            }
        }else{
            return redirect('login_admin_bpk');
        }
        $array = [
            'info' => 'your account has expired',
            'status' => false
        ];
        return $array;
    }

    public function halaman_superadmin_bpk(){
            return view('content_bpk.page_dashboard.dashboard');
    }

    public function loginbpka(Request $req)
    {
       $this->validate($req, [
          'username'=> 'required',
          'password' => 'required',
          'provinsi'=> 'required|numeric',
          'kabupaten' => 'required|numeric'
       ]);

       $username = $req->username;
       $password = $req->password;
       $provinsi = $req->provinsi;
       $kabupaten = $req->kabupaten;

       $model = userBpk::where('username',$username)->where('province_id', $provinsi)->where('distric_id', $kabupaten)->first();
       $model_inspektorat = inspektorat::where('username',$username)->where('province_id', $provinsi)->where('distric_id', $kabupaten)->first();
       $model_inspektorat_pemkot = inspektorat_pemkot::where('username',$username)->where('province_id', $provinsi)->where('distric_id', $kabupaten)->first();
       $model_inspektorat_pemkab = inspektorat_pemkab::where('account',$username)->where('province_id', $provinsi)->where('district_id', $kabupaten)->first();


       if(count($model)>0)
       {

           if(Hash::check($password, $model->password)){
               $req->session()->put('nama', $model->username);
               $req->session()->put('id_user_bpk', $model->id);
               return redirect('halaman_instansi');
           }
           $req->session()->flash('message_fail','Password anda salah');
           return redirect('loginbpk#login-bpk');
       }
        if(count($model_inspektorat)>0){
            if(Hash::check($password, $model_inspektorat->password)){
                $req->session()->put('nama', $model_inspektorat->account);
                $req->session()->put('id_user_inspektorat', $model_inspektorat->id);
                return redirect('halaman_instasi_inspetorat');
            }
            $req->session()->flash('message_fail','Password anda salah');
            return redirect('loginbpk#login-bpk');
        }

       if(count($model_inspektorat_pemkot)>0)
       {
           if(Hash::check($password, $model_inspektorat_pemkot->password)){
               $req->session()->put('nama', $model_inspektorat_pemkot->username);
               $req->session()->put('id_user_inspektorat_pemkot', $model_inspektorat_pemkot->id);
               return redirect('halaman_instasi_inspetorat_pemkot');
           }
           $req->session()->flash('message_fail','Password anda salah');
           return redirect('loginbpk#login-bpk');
       }

        if(count($model_inspektorat_pemkab)>0)
        {
            if(Hash::check($password, $model_inspektorat_pemkab->password)){
                $req->session()->put('nama', $model_inspektorat_pemkab->account);
                $req->session()->put('id_user_inspektorat_pemkab', $model_inspektorat_pemkab->id);
                return redirect('halaman_inspektorat_pemkab');
            }
            $req->session()->flash('message_fail','Password anda salah');
            return redirect('loginbpk#login-bpk');
        }

        return redirect('loginbpk#login-bpk');

       //return view('content2.page_login.bpk_login');
    }

    public function loginInspektorats(Request $req)
    {
        $this->validate($req, [
            'username'=> 'required',
            'password' => 'required',
            'provinsi'=> 'required',
            'kabupaten' => 'required'
        ]);

        $username = $req->username;
        $password = $req->password;
        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;
        $model = inspektorat::where('username',$username)->where('province_id', $provinsi)->where('distric_id', $kabupaten)->first();

        if(count($model)>0)
        {
            if(Hash::check($password, $model->password)) {
                $req->session()->put('nama', $model->username);
                $req->session()->put('id_user_inspektorat', $model->id);

                return redirect('halaman_instasi_inspetorat');
            }
        }

        return redirect('signup_inspektorat');

        //return view('content2.page_login.bpk_login');
    }

    public function keluar_pegawai(Request $req){
        $req->session()->forget('user_id');
        $req->session()->forget('nama');
        return redirect('halaman_instansi');
    }

    public function keluar_pegawai_in(Request $req){
        $req->session()->forget('user_id');
        $req->session()->forget('nama');
        return redirect('halaman_instasi_inspetorat');
    }


    public function keluar_pegawai_in_pemkot(Request $req){
        $req->session()->forget('user_id');
        $req->session()->forget('nama');
        return redirect('halaman_instasi_inspetorat_pemkot');
    }

    public function keluar_pegawai_in_pemkab(Request $req){
        $req->session()->forget('user_id');
        $req->session()->forget('nama');
        return redirect('halaman_inspektorat_pemkab');
    }


    public function cekEmail($email)
    {
        $load_model_user = user::where('email', $email)->count('id');
        return $load_model_user;
    }

    public function Signout(Request $req){
        Auth::logout();
        $req->session()->forget('user_id');
        $req->session()->forget('nama');
        return redirect('/');
    }
}
