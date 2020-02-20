<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Session;
use Validation;
use Redirect;

use App\Authorized as berwenang;

class AuthorizedController extends Controller
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

    public function checkSession()
    {
        if(empty(Session::get('user_id')))
        {
            Redirect::to('/')->send();
        }
    }

    public function index(){
        $this->checkSession();
        $berwenang = berwenang::where('user_id', Session::get('user_id'))->get();
        $pass = array(
            'berwenang'=> $berwenang
        );
        return view('content2.page_authorized.index', $pass);
    }

    public function create()
    {
        return view('content2.page_authorized.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'nama_berwenang'=> 'required',
            'level'=> 'required'
        ]);

        $nama_berwenang= $req->post('nama_berwenang');
        $nip= $req->post('nip');
        $level= $req->post('level');

        $mode_berwenang = new berwenang([
            'nama_berwenang'=>$nama_berwenang,
            'nip' => $nip,
            'level'=> $level,
            'user_id'=> Session::get('user_id')
        ]);

        if($mode_berwenang->save()){
            return redirect('authorized');
        }

        return redirect('authorized');

    }

    public function edit($id)
    {
        $berwenang_model = berwenang::find($id);
        return view('content2.page_authorized.edit', array('data'=>$berwenang_model));
    }


    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'nama_berwenang'=> 'required',
            'level'=> 'required'
        ]);

        $nama_berwenang= $req->post('nama_berwenang');
        $nip= $req->post('nip');
        $level= $req->post('level');

        $mode_berwenang = berwenang::find($id);
        $mode_berwenang->nama_berwenang = $nama_berwenang;
        $mode_berwenang->nip= $nip;
        $mode_berwenang->level= $level;

        if($mode_berwenang->save()){
            return redirect('authorized');
        }

        return redirect('authorized');

    }

    public function delete(Request $req, $id)
    {

        $mode_berwenang = berwenang::find($id);
        if($mode_berwenang->delete()){
            return redirect('authorized');
        }

        return redirect('authorized');

    }
}
