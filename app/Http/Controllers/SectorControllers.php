<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Sector as bidang;
use Session;
use Validation;
use Redirect;

class SectorControllers extends Controller
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
        $bidang = bidang::where('user_id', Session::get('user_id'))->get();
        $pass = array(
            'bidang'=> $bidang
        );
        return view('content2.page_sector.index', $pass);
    }

    public function create(){
        return view('content2.page_sector.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'sector'=>'required'
        ]);

        $sector= $req->sector;

        $bidang_model = new bidang([
            'sector_name' => $sector,
            'user_id'=> Session::get('user_id')
        ]);

        if($bidang_model->save()){
            return redirect('sector');
        }

        return redirect('sector/create');
    }

    public function edit($id){
        $pass = bidang::find($id);
        return view('content2.page_sector.edit', array('bidang'=>$pass));
    }


    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'sector'=>'required'
        ]);

        $sector= $req->sector;

        $bidang_model = bidang::find($id);
        $bidang_model->sector_name = $sector;

        if($bidang_model->save()){
            return redirect('sector');
        }

        return redirect('sector/create');
    }

    public function delete(Request $req, $id){
        $bidang_model = bidang::find($id);
        if($bidang_model->delete()){
            return redirect('sector');
        }
        return redirect('sector');
    }

}
