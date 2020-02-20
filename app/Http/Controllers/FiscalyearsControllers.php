<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Fiscal_years as fiscalYears;

use Session;

use Redirect;

class FiscalyearsControllers extends Controller
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

    public function index()
    {
        $this->checkSession();
        $pass=array(
          'fiscalYears' => fiscalYears::all()->whereIn('user_id', Session::get('user_id'))
        );
        return view('content2.page_fiscalyears.index', $pass);
    }

    public function create()
    {
        return view('content2.page_fiscalyears.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
           'years' => 'required|numeric',
            'status'=> 'required'
        ]);

        $tahun_anggaran = $req->years;
        $status= $req->status;
        $master_id = Session::get('user_id');
        $fiscalYears = new fiscalYears([
            'years'=>$tahun_anggaran,
            'status'=>$status,
            'user_id'=> $master_id
        ]);

        if ($fiscalYears->save())
        {
            $req->session()->flash('message_success', 'Tahun anggaran sudah ditambahkan');
            return redirect('fiscalyears');
        }

        $req->session()->flash('message_fails', 'Tahun anggaran gagal ditambahkan');
        return redirect('fiscalyears/create');
    }

    public function edit($id)
    {
        $pass = array(
            'years' => fiscalYears::find($id)
        );
        return view('content2.page_fiscalyears.edit', $pass);
    }

    public function update($id, Request $req)
    {
        $this->validate($req,[
           'years' => 'required|numeric',
            'status'=> 'required'
        ]);

        $tahun_anggaran = $req->years;
        $status = $req->status;

        $fiscalYears = fiscalYears::find($id);
        $fiscalYears->years = $tahun_anggaran;
        $fiscalYears->status = $status;

        if($fiscalYears->save())
        {
            $req->session()->flash('message_success', 'Tahun Anggaran Berhasil diubah');
            $update_yanglain = fiscalYears::where('id','!=', $fiscalYears->id)->update(
                ['status'=>'0']
            );
            return redirect('fiscalyears');
        }

        $req->session()->flash('message_fails','Tahun Anggaran gagal diubah');
        return redirect('fiscalyears/'.$id.'/edit');
    }

    public function destroy($id, Request $req)
    {
        $fiscalYears = fiscalYears::find($id);
        if ($fiscalYears->delete())
        {
            $req->session()->flash('message_success', 'Tahun Anggaran Berhasil diubah');
            return redirect('fiscalyears');
        }
        $req->session()->flash('message_fails','Tahun Anggaran gagal dihapus');
        return redirect('fiscalyears');
    }
}
