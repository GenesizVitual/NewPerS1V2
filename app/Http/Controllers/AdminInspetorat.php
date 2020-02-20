<?php

namespace App\Http\Controllers;

use App\hak_akses_diperindak;
use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Session;
use Sessio;
use App\Account_inspektorat as account_admin_inspektorat;
use App\Province as provinsi;
use App\District as Kabupaten;
use App\Instance as instansi;
use App\UserInspektorat as user_disperindak;
use App\hak_akses_diperindak as hak_akses;

class AdminInspetorat extends Controller
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

    public function getMasterIdInspektoratInfo(){
        $model = account_admin_inspektorat::find(Session::get('id_admin_inspektorat_pemprov'));
        return $model;
    }

    public function index(){
        $model_master = $this->getMasterIdInspektoratInfo();
        $data=[
            'data'=> user_disperindak::where('province_id', $model_master->province_id)->get(),
            'dataMaster'=>$model_master
        ];
        return view('content_inspektorat.page_account.index', $data);
    }

    public function create(){
        $model_master = $this->getMasterIdInspektoratInfo();
        $data=[
            'provinsi'=>provinsi::all(),
            'kabupaten'=>Kabupaten::all(),
            'dataMaster'=>$model_master
        ];

        return view('content_inspektorat.page_account.new', $data);
    }

    public function store(Request $req){
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required',
            'provinsi' => 'required|numeric',
            'kabupaten' =>'required|numeric'
        ]);

        $model = new user_disperindak();
        $model->username = $req->username;
        $model->password = bcrypt($req->password);
        $model->province_id = $req->provinsi;
        $model->distric_id = $req->kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success', 'Akun Bpk berhasil ditambahkan');
            return redirect('buatAccoutAdminInspektorat');
        }

        $req->session()->flash('message_fail', 'Akun Bpk berhasil ditambahkan');
        return redirect('buatAccoutAdminInspektorat');
    }

    public function edit($id){
        $model_master = $this->getMasterIdInspektoratInfo();
        $pass = array(
            'provinsi'=> provinsi::all(),
            'kabupaten'=> Kabupaten::all(),
            'data'=> user_disperindak::find($id),
            'dataMaster'=> $model_master
        );
        return view('content_inspektorat.page_account.edit', $pass);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'username' => 'required',
            'password' => 'required',
            'provinsi' => 'required|numeric',
            'kabupaten' =>'required|numeric'
        ]);

        $model = user_disperindak::find($id);
        $model->username = $req->username;
        $model->password = bcrypt($req->password);
        $model->province_id = $req->provinsi;
        $model->distric_id = $req->kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success', 'Akun Bpk berhasil diubah');
            return redirect('buatAccoutAdminInspektorat');
        }

        $req->session()->flash('message_fail', 'Akun Bpk berhasil diubah');
        return redirect('buatAccoutAdminInspektorat');
    }

    public function delete(Request $req, $id){
        $model = user_disperindak::find($id);
        if($model->delete())
        {
            $req->session()->flash('message_success', 'Akun Bpk berhasil dihapus');
            return redirect('buatAccoutAdminInspektorat');
        }

        $req->session()->flash('message_fail', 'Akun Bpk berhasil dihapus');
        return redirect('buatAccoutAdminInspektorat');
    }

    public function hak_akses($id)
    {
        $user_bpk = user_disperindak::find($id);
        return view('content_inspektorat.page_hak_akses.index', array('data'=> $user_bpk));
    }

    public function get_hak_akses($id)
    {
        $userBpk = user_disperindak::find($id);
        $dataInstansi = instansi::where('province_id', $userBpk->province_id)->where('district_id', $userBpk->distric_id)->
            where('tingkat',1)->get();

        $no =1;
        $column=[];
        foreach ($dataInstansi as $value)
        {
            $row=[];
            $row[]=$no++;
            $row[]=$value->instance;
            $checkBox='<input type="checkbox"  id="pilih" onchange="checkUncheck(this,'.$value->id.')">';
            $hak_akses = hak_akses::where('admin_disperindak_id', $id)->where('instansi_id', $value->id)->count('id');

            if($hak_akses > 0)
            {
                $checkBox='<input type="checkbox" onchange="checkUncheck(this,'.$value->id.')" checked>';
            }

            switch ($value->tingkat)
            {
                case 1:
                    $row[] = "Provinsi";
                    break;
                case 2:
                    $row[] = "Kota";
                    break;
                case 3 :
                    $row[] = "Kabupaten";
                    break;
                default :
                    $row[] = "Tingkat Belum dimasukan";
                    break;
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

        $id_disperindak = $id;

        $hak_akses = new hak_akses_diperindak();
        $hak_akses->admin_disperindak_id = $id_disperindak;
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

        $hak_akses =  hak_akses::where('instansi_id',$req->instansi)->where('admin_disperindak_id', $id)->first();
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
