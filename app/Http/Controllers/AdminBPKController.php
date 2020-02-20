<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Session;

use App\AccountBpk as accountBpk;

use App\UserBpk as userBpk;

use App\Province as province;

use App\District as district;

use App\Instance as instansi;

use App\HakAkses as hak_akses;

class AdminBPKController extends Controller
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

    public function call_master_admin_bpk(){
        $model_account =  accountBpk::find(Session::get('id_admin_bpk'));
        return $model_account;
    }

    public function index(){
        $data = $this->call_master_admin_bpk();
       $pass = [
            'data'=> userBpk::where('province_id', $data->province_id)->get(),
       ];
        return view('content_bpk.page_account.index', $pass);
    }

    public function create(){
        $data = $this->call_master_admin_bpk();
        $pass = array(
            'provinsi'=> province::all(),
            'kabupaten'=> district::all(),
            'dataMaster'=> $data
        );
        return view('content_bpk.page_account.new', $pass);
    }
    public function edit($id){
        $data = $this->call_master_admin_bpk();
        $pass = array(
            'provinsi'=> province::all(),
            'kabupaten'=> district::all(),
            'data'=> userBpk::find($id),
            'dataMaster'=> $data
        );
        return view('content_bpk.page_account.edit', $pass);
    }

    public function store(Request $req){
        $this->validate($req,[
           'username' => 'required',
           'password' => 'required',
           'provinsi' => 'required|numeric',
           'kabupaten' =>'required|numeric'
        ]);

        $model = new userBpk();
        $model->username = $req->username;
        $model->password = bcrypt($req->password);
        $model->province_id = $req->provinsi;
        $model->distric_id = $req->kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success', 'Akun Bpk berhasil ditambahkan');
            return redirect('bpkAccount');
        }

        $req->session()->flash('message_fail', 'Akun Bpk berhasil ditambahkan');
        return redirect('tambah_akun');
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required',
            'provinsi' => 'required|numeric',
            'kabupaten' =>'required|numeric'
        ]);

        $model = userBpk::find($id);
        $model->username = $req->username;
        $model->password = bcrypt($req->password);
        $model->province_id = $req->provinsi;
        $model->distric_id = $req->kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success', 'Akun Bpk berhasil diubah');
            return redirect('bpkAccount');
        }

        $req->session()->flash('message_fail', 'Akun Bpk berhasil diubah');
        return redirect('bpkAccount');
    }

    public function delete(Request $req, $id){

        $model = userBpk::find($id);
        if($model->delete())
        {
            $req->session()->flash('message_success', 'Akun telah dihapus');
            return redirect('bpkAccount');
        }

        $req->session()->flash('message_fail', 'Akun telah gagal dihapus');
        return redirect('bpkAccount');
    }

    public function hak_akses($id)
    {
        $user_bpk = userBpk::find($id);
       return view('content_bpk.page_hak_akses.index', array('data'=> $user_bpk));
    }

    public function get_hak_akses($id)
    {
        $userBpk = userBpk::find($id);
        $dataInstansi = instansi::where('province_id', $userBpk->province_id)->where('district_id', $userBpk->distric_id)->get();

        $no =1;
        $column=[];
        foreach ($dataInstansi as $value)
        {
            $row=[];
            $row[]=$no++;
            $row[]=$value->instance;
            $row[]=$value->getProvince->province;
            $row[]=$value->getDistrict->district;
            $checkBox='<input type="checkbox"  id="pilih" onchange="checkUncheck(this,'.$value->id.')">';
            $hak_akses = hak_akses::where('admin_bpk_id', $id)->where('instansi_id', $value->id)->count('id');

            if($hak_akses > 0)
            {
                $checkBox='<input type="checkbox" onchange="checkUncheck(this,'.$value->id.')" checked>';
            }

            if($value->tingkat==1){
                $row[] = "Provinsi";
            }elseif ($value->tingkat==2){
                $row[] = "Kota";
            }elseif ($value->tingkat==3){
                $row[] = "Kabupaten";
            }else{
                $row[] = "Tingkat Belum dimasukan";
            }

            $row[]=$checkBox;

            $column[] = $row;
        }

        $output = array('data'=> $column);
        return response()->json($output);
    }

    public function tambah_hak_akses(Request $req, $id){

        $this->validate($req,[
            'instansi'=>'required',
        ]);

         $id_bpk = $id;

         $hak_akses = new hak_akses();
         $hak_akses->admin_bpk_id = $id_bpk;
         $hak_akses->instansi_id = $req->instansi;
         if($hak_akses->save()){
             $infor = [
                 'info'=> 'success adding',
                 'status'=> true
             ];
             return response()->json($infor);
         }

        $infor = [
            'info'=> 'fail adding',
            'status'=> false
        ];
        return response()->json($infor);
        //return $req->all();
    }

    public function hapus_hak_akses(Request $req, $id){
        $this->validate($req,[
            'instansi'=>'required',
        ]);

        $hak_akses =  hak_akses::where('instansi_id',$req->instansi)->where('admin_bpk_id', $id)->first();
        if($hak_akses->delete()){
            $infor = [
                'info'=> 'success delete',
                'status'=> true
            ];
            return response()->json($infor);
        }
        $infor = [
            'info'=> 'fail delete',
            'status'=> false
        ];
        return response()->json($infor);
        //return $req->all();
    }
}
