<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Admin_inspektorat_pemkab as user_pemkab;

use App\Instance as instansi;

use App\HakAksesInspektoratPemkab as hak_akses;

class HakAksesInspektoratPemKab extends Controller
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


            return $next($req);
        });
    }


    public function daftar_instansi($id)
    {
        $data=[
            'data' => user_pemkab::find($id)
        ];
        return view('content_inspektorat_pemkab.page_hak_akses.index',$data);
    }

    public function get_hak_akses($id)
    {
        $userinstasi = user_pemkab::find($id);
        $dataInstansi = instansi::where('province_id', $userinstasi->province_id)->where('district_id', $userinstasi->district_id)->where(function ($query){
            $query->where('tingkat','3');
        })->get();

        $no =1;
        $column=[];
        foreach ($dataInstansi as $value)
        {
            $row=[];
            $row[]=$no++;
            $row[]=$value->instance;
            $checkBox='<input type="checkbox"  id="pilih" onchange="checkUncheck(this,'.$value->id.')">';
            $hak_akses = hak_akses::where('admin_inspektorat_pemkab', $id)->where('instansi_id', $value->id)->count('id');

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

        $id_inspektorat = $id;

        $hak_akses = new hak_akses();
        $hak_akses->admin_inspektorat_pemkab = $id_inspektorat;
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

        $hak_akses =  hak_akses::where('instansi_id',$req->instansi)->where('admin_inspektorat_pemkab', $id)->first();
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
