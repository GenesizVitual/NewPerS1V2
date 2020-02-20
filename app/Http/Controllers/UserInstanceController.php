<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use App\Instance;
use Faker\Provider\File;
use Illuminate\Http\Request;

use Session;

use App\Management_user as user_instance;

use App\User as user;

use App\Instance as instansi;

use Redirect;

class UserInstanceController extends Controller
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
        $data_userInstansi = user_instance::all()->where('user_id',Session::get('user_id'));

        $pass = array(
            'data_userinstansi' => $data_userInstansi
        );
        return view('content2.page_userInstance.index', $pass);
    }

    public function create()
    {
        $pass = array(
            'instansi' => $this->Instance()
        );
        return view('content2.page_userInstance.new', $pass);
    }

    public function store(Request $req)
    {

        $this->validate($req, [
            'username'=>'required',
            'password'=> 'required|min:5',
            'name' => 'required',
            'instance_id'=> 'required',
            'foto' => 'image|mimes:jpeg,png,gif,jpg|max:2048'
        ]);

        $username = $req->username;
        $password = $req->password;
        $name = $req->name;
        $instance_id = $req->instance_id;
        $master_id = Session::get('user_id');

        if($foto=$req->hasFile('foto')){
            $foto = $req->foto;
            $filename = time() .'.'. $foto->getClientOriginalExtension();
            $foto->move(public_path('ManagementUserPhoto'), $filename);
        }else{
            $filename='default.png';
        }


        $created = new user_instance([
            'username' => $username,
            'name' => $name,
            'password' => $password,
            'instance_id' => $instance_id,
            'photo' => $filename,
            'user_id' => $master_id,
        ]);

        if($created->save()){
            $req->session()->flash('message_success', 'Akun Baru Sudah didaftarkan');
            return redirect('createAccount');
        }

        $req->session()->flash('message_fail', 'Akun Baru gagal didaftarkan');
        return redirect('newAccount');
    }

    public function edit($id)
    {
        $userInstance = array(
            'userInstance' => user_instance::find($id)
        );
        return view('content2.page_userInstance.edit', $userInstance);
    }

    public function update($id, Request $req)
    {
        $this->validate($req, [
            'username'=>'required',
            'password'=> 'required|min:5',
            'name' => 'required',
            'foto' => 'image|mimes:jpeg,png,gif,jpg|max:2048'
        ]);

        $username = $req->username;
        $password = $req->password;
        $name = $req->name;

        $usertInstance = user_instance::find($id);
        $usertInstance->fill($req->except('foto'));

        $usertInstance->username = $username;
        $usertInstance->password = $password;
        $usertInstance->name = $name;

        if($file = $req->hasFile('foto'))
        {
            $file = $req->foto;
            $filename = time().'.'.$file->getClientOriginalExtension();
            $file->model(public_path('ManagementUserPhoto'), $filename);
            $usertInstance->photo = $filename;
        }else{
            $usertInstance->photo = 'default.png';
        }


        if($usertInstance->save())
        {
            $req->session()->flash('message_success', 'Data berhasil diubah');
            return redirect('createAccount');
        }


        $req->session()->flash('message_fail', 'Data gagal diubah');
        return redirect('newAccount/'.$id.'/edit');
    }

    public function setujui($token)
    {
        $usertInstance = user::where('remember_token',$token)->first();
        $usertInstance->status_verifikasi= 1;

        if($usertInstance->save())
        {
            $status = "Akun anda telah aktif, silahkan login.";
            return redirect('login#login')->with('message_success', $status);
        }

        $status = "Email anda telah tersedia, silahkan login";
        return redirect('login')->with('message_success', $status);
    }

    public function destroy($id, Request $req)
    {
        $userIntance = user_instance::find($id);
        if($userIntance->delete())
        {
            if($req->foto != 'default.png')
            {
                File::delete(public_path('ManagementUserPhoto/'.$req->foto));
                $req->session()->flash('message_success','Akun Telah dihapus');
                return redirect('createAccount');
            }else
            {
                $req->session()->flash('message_success','Akun Telah dihapus');
                return redirect('createAccount');
            }
        }
        $req->session()->flash('message_fails','Akun Gagal dihapus');
        return redirect('createAccount');
    }

    //======================================================================================================

    private function Instance()
    {
        $instansi = Instance::all();
        $pass = $instansi->where('user_id',Session::get('user_id'));
        return $pass;
    }
}
