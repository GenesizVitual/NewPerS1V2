<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Dpa as Dpa;

use App\Fiscal_years as thn_anggaran;

use Session;

use Redirect;



class DpaController extends Controller
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
         $pass = array(
            'data'=> Dpa::where('user_id', Session::get('user_id'))->get()
        );

        return view('content2.page_dpa.index', $pass);
    }

    public function create(){
        $pass = array(
            'thn_anggaran' => thn_anggaran::where('user_id', Session::get('user_id'))->get()
        );
        return view('content2.page_dpa.new', $pass);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'fiscal_id'=>'required',
            'nilai_anggaran'=> 'required'
        ]);

        $taahun_anggaran_id = $req->post('fiscal_id');
        $nilai_anggaran = $req->post('nilai_anggaran');

        $dpa_model = new Dpa([
            'pagu_value'=>$nilai_anggaran,
            'fiscal_years_id'=>$taahun_anggaran_id,
            'user_id'=> Session::get('user_id')
        ]);

        if($dpa_model->save()){
            $req->session()->flash('message_success','berhasil memasukan dpa');
            return redirect('dpa');
        }

        $req->session()->flash('message_fail','Gagal memasukan dpa');
        return redirect('dpa');
    }

    public function edit(Request $req, $id){

        $data = array(
            'data' => Dpa::find($id),
            'thn_anggaran'=> thn_anggaran::where('user_id', Session::get('user_id'))->get()
        );

        return view('content2.page_dpa.edit', $data);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'fiscal_id'=>'required',
            'nilai_anggaran'=> 'required'
        ]);

        $taahun_anggaran_id = $req->post('fiscal_id');
        $nilai_anggaran = $req->post('nilai_anggaran');


        $dpa_model = Dpa::find($id);
        $dpa_model->pagu_value =  $nilai_anggaran;
        $dpa_model->fiscal_years_id = $taahun_anggaran_id;

        if($dpa_model->save()){
            $req->session()->flash('message_success','berhasil mengubah dpa');
            return redirect('dpa');
        }

        $req->session()->flash('message_fail','Gagal mengubah dpa');
        return redirect('dpa');
    }

    public function delete(Request $req, $id)
    {
        $dpa_model = Dpa::find($id);
        if(empty($dpa_model->getDPADariProgram)){
            if($dpa_model->delete()){
                $req->session()->flash('message_success','berhasil menghapus dpa');
                return redirect('dpa');
            }
        }else{
            $req->session()->flash('message_fail','Dpa ini tidak dapat dihapus karena telah digunakan pada menu DPA Persediaan -> Program, Kegiatan, Dan Belanja');
            return redirect('dpa');
        }
        $req->session()->flash('message_fail','Gagal menghapus dpa');
        return redirect('dpa');
    }

}
