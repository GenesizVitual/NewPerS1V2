<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Instance as instance;

use App\Province as province;

use App\District as district;

use Session;
use Redirect;

class InstanceController extends Controller
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


    public function getUserId()
    {
        $user_id = Session::get('user_id');
        return $user_id;
    }

    public function checkSession()
    {
        if(empty(Session::get('user_id')))
        {
            Redirect::to('/')->send();
        }
    }

    public function index()
    {
        $this->checkSession();
        $instance = array(
            'instansi_profil'=> instance::all()->where('user_id', Session::get('user_id'))->first()
        );

        return view('content2.page_instance.index', $instance);
    }

    public function create()
    {
        $pass = array(
            'provinsi'=> province::all(),
            'kabupaten'=> district::all()
        );
        return view('content2.page_instance.new', $pass);
    }

    public function store(Request $req)
    {

        $this->validate($req, [
            'nama_instansi' => 'required',
            'singkatan_instansi' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required|numeric',
            'fax' => 'required|numeric',
            'logo' => 'required|image|mimes:jpg,jpeg,png,gif,jpg|max:2048'
        ]);

        $name_instansi = $req->nama_instansi;
        $singkatan = $req->singkatan_instansi;
        $provinsi = $req->provinsi;
        $kabupaten = $req->kabupaten;
        $alamat = $req->alamat;
        $no_telp = $req->no_telp;
        $fax = $req->fax;
        $logo = $req->logo;

        $imagename = time() . '.' . $logo->getClientOriginalExtension();

        $instansi = new instance([
            'instance' => $name_instansi,
            'singkatan_instansi' => $singkatan,
            'province_id' => $provinsi,
            'district_id' => $kabupaten,
            'alamat' => $alamat,
            'no_telp' => $no_telp,
            'logo' => $imagename,
            'user_id'=> $this->getUserId()
        ]);

        if ($instansi->save()){
            if ($logo->move(public_path('logo'), $imagename)) {
                $req->session()->flash('message_success','Instansi Berhasil dibuat');
                return redirect('profileInstansi');
            }else{
                $req->session()->flash('message_fail','Instansi Berhasil dibuat tapi logo tidak ter upload');
                return redirect('profileInstansi');
            }
        }

        $req->session()->flash('message_fail', 'Instansi Gagal dibuatkan');
        return redirect('profilInstansi');
    }

    public function edit($id)
    {
        $data = array(
            'provinsi'=> province::all(),
            'kabupaten'=> district::all(),
            'data_instansi' => instance::find($id)
        );
        return view('content2.page_instance.edit', $data);
    }

    public function getData(){
        $master_id = Session::get('user_id');
        $data = instance::where('user_id', $master_id)->first();
        return response()->json($data);
    }
    public function update($id, Request $req)
    {
         $this->validate($req, [
            'nama_instansi' => 'required',
            'singkatan_instansi' => 'required',
//            'provinsi' => 'required',
//            'kabupaten' => 'required',
            'tingkat' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required',
           'logo' => 'image|mimes:jpeg,png,gif,jpg|max:2048'
        ]);

         $name_instansi = $req->nama_instansi;
        $singkatan_instansi = $req->singkatan_instansi;
//        $provinsi = $req->provinsi;
//        $kabupaten = $req->kabupaten;
        $alamat = $req->alamat;
        $no_telp = $req->no_telp;
        $fax = $req->fax;
        $tingkat = $req->tingkat;

        $dataInstansi = instance::find($id);
        $dataInstansi->fill($req->except('logo'));

        $dataInstansi->instance = $name_instansi;
        $dataInstansi->singkatan_instansi = $singkatan_instansi;
//        $dataInstansi->province_id = $provinsi;
//        $dataInstansi->district_id = $kabupaten;
        $dataInstansi->alamat = $alamat;
        $dataInstansi->no_telp = $no_telp;
        $dataInstansi->fax = $fax;
        $dataInstansi->tingkat = $tingkat;

        if(!empty($req->logo)){
            if($file = $req->hasFile('logo'))
            {
                $file= $req->file('logo');
                $filename = time().'.'.$file->getClientOriginalExtension();
                $file->move(public_path('logo'), $filename);
                $dataInstansi->logo = $filename;
            }
        }

        if($dataInstansi->save())
        {
            $req->session()->flash('message_success','Profil instansi berhasil terubah');
            return redirect('profileInstansi');
        }

        return $id;
    }
}
