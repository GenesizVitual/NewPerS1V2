<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\AccountBpk as superadminBpk;

use App\Province as province;

use App\District as kabupaten;

use Session;

class SuperadminBpkController extends Controller
{
    //

    public function index()
    {
        $pass = [
            'data' => superadminBpk::all()
        ];
        return view('content_superadmin.superadminBpk.view', $pass);
    }

    public function create()
    {
       $data=[
           'provinsi'=> province::all(),
           'kabupaten'=>kabupaten::all()
       ];
       return view('content_superadmin.superadminBpk.new', $data);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'username'=> 'required',
            'password'=> 'required|min:6',
            'provinsi'=> 'required',
            'kabupaten'=> 'required'
        ]);

        $username   = $req->username;
        $password   = bcrypt($req->password);
        $provinsi   = $req->provinsi;
        $kabupaten  = $req->kabupaten;

        $model  = new superadminBpk();
        $model->account         = $username;
        $model->password        = $password;
        $model->province_id	    = $provinsi;
        $model->district_id	    = $kabupaten;

        if($model->save())
        {
            $req->session()->flash('message_success','Superadmin baru berhasil ditambahkan');
            return redirect('superadminbpk');
        }

        $req->session()->flash('message_fail','Superadmin gagal ditambahkan');
        return redirect('superadminbpk');

    }

    public function edit($id)
    {
        $pass=[
            'data' => superadminBpk::find($id),
            'provinsi'=> province::all(),
            'kabupaten'=>kabupaten::all()
        ];

        return view('content_superadmin.superadminBpk.edit', $pass);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'username'=> 'required',
            'password'=> 'required|min:6',
            'provinsi'=> 'required',
            'kabupaten'=> 'required'
        ]);

        $username   = $req->username;
        $password   = bcrypt($req->password);
        $provinsi   = $req->provinsi;
        $kabupaten  = $req->kabupaten;

        $model  = superadminBpk::find($id);
        $model->account        = $username;
        $model->password        = $password;
        $model->province_id	    = $provinsi;
        $model->district_id	    = $kabupaten;
        if($model->save())
        {
            $req->session()->flash('message_success','Superadmin baru berhasil diubah');
            return redirect('superadminbpk');
        }

        $req->session()->flash('message_fail','Superadmin gagal diubah');
        return redirect('superadminbpk');

    }

    public function delete(Request $req, $id)
    {
        $model  = superadminBpk::find($id);

        if($model->delete())
        {
            $req->session()->flash('message_success','Superadmin baru berhasil dihapus');
            return redirect('superadminbpk');
        }

        $req->session()->flash('message_fail','Superadmin gagal dihapus');
        return redirect('superadminbpk');

    }
}
