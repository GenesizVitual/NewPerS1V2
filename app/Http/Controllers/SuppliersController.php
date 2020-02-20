<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Session;

use App\Suppliers as suppliers;
use Redirect;

class SuppliersController extends Controller
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
        $pass = array(
            'supplier'=> suppliers::all()->whereIn('user_id', Session::get('user_id'))
        );
        return view('content2.page_suppliers.index', $pass);
    }

    public function create()
    {
        return view('content2.page_suppliers.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'suppliers'=>'required',
            'pimpinan'=>'required',
            'alamat' => 'required',
            'no_kontak' => 'required'
        ]);

        $suppliers = $req->suppliers;
        $alamat = $req->alamat;
        $no_kontak = $req->no_kontak;
        $pimpinan = $req->pimpinan;

        $master_id = Session::get('user_id');

        $count = suppliers::where('suppliers','like',$suppliers.'%')->where('user_id', $master_id)->count();

        $suppliersModels = new suppliers([
           'suppliers' => $suppliers,
           'pimpinan' => $pimpinan,
            'alamat'=>$alamat,
            'no_kontak_supplier'=>$no_kontak,
            'user_id'=> $master_id
        ]);
        if($count >= 1)
        {
            $req->session()->flash('message_warning','Supplier Sudah Ada');
            return redirect('suppliers');
        }else{
            if($suppliersModels->save())
            {
                $req->session()->flash('message_success','Supplier berhasil ditambahkan');
                return redirect('suppliers');
            }
        }

        $req->session()->flash('message_fails','Supplier gagal ditambahkan');
        return redirect('suppliers/create');
    }

    public function edit($id)
    {
        $pass = array(
            'suppliers' => suppliers::find($id)
        );
        return view('content2.page_suppliers.edit', $pass);
    }

    public function detail_supplier($id)
    {
        $pass = array(
            'suppliers' => suppliers::find($id)
        );
        return response()->json($pass);
    }

    public function update($id,Request $req)
    {
        $this->validate($req,[
            'suppliers'=>'required',
            'alamat' => 'required',
            'pimpinan' => 'required',
            'no_kontak' => 'required'
        ]);

        $suppliers = $req->suppliers;
        $alamat = $req->alamat;
        $no_kontak = $req->no_kontak;
        $pimpinan = $req->pimpinan;

        $master_id = Session::get('user_id');

        $suppliersModels = suppliers::find($id);
        $suppliersModels->suppliers = $suppliers;
        $suppliersModels->pimpinan = $pimpinan;
        $suppliersModels->alamat = $alamat;
        $suppliersModels->no_kontak_supplier = $no_kontak;
        $suppliersModels->user_id = $master_id;
        if($suppliersModels->save())
        {
            $req->session()->flash('message_success','Supplier berhasil diubah');
            return redirect('suppliers');
        }
        $req->session()->flash('message_fails','Supplier gagal diubah');
        return redirect('suppliers/'.$id.'/edit');
    }

    public function destroy($id, Request $req)
    {
        $suppliersModel = suppliers::find($id);
        if($suppliersModel->delete())
        {
            $req->session()->flash('message_success','Supplier berhasil dihapus');
            return redirect('suppliers');
        }

        $req->session()->flash('message_fails','Supplier gagal dihapus');
        return redirect('suppliers/'.$id.'/delete');
    }

}
