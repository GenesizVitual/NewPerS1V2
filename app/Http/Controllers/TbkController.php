<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Spj as spj;

use App\Tbk as tbk;

use Session;

use Redirect;

class TbkController extends Controller
{
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



    public function tbk_list($id)
    {

        $pass = array(
            'tbkList'=>tbk::all()->where('spj_id', $id)->whereIn('user_id', Session::get('user_id')),
            'spj'=>spj::find($id)
        );
        return view('content.page_spjTbk.index', $pass);
    }

   public function tbk_respone($id)
    {
        $pass = array(
            'tbk'=>tbk::all()->where('spj_id',$id)
        );
        return response()->json($pass);
    }

    public function createtbk($id)
    {
        $pass = array(
            'spj'=>spj::find($id)
        );

        return view('content.page_spjTbk.new', $pass);
    }

    public function tbkStore($id,Request $req)
    {
        $this->validate($req,[
            'numberTbk'=>'required'
        ]);

        $spj_id = $id;
        $number_tbk = $req->numberTbk;

        $tbkModel = new tbk([
            'number_tbk'=>$number_tbk,
            'spj_id' => $spj_id,
            'user_id'=> Session::get('user_id')
        ]);

        if($tbkModel->save()){
            //$req->session()->flash('message_success', 'Tbk Berhasil Dibuatkan');
            //return redirect('tbk/'.$spj_id.'/list');
            $feedback = [
                'status'=> true,
                'number_tbk'=> $number_tbk
            ];

            return $feedback;
        }
        //$req->session()->flash('message_fails', 'Tbk Gagal dibuatkan');
        //return redirect('tbk/'.$spj_id.'/create');
        $feedback = [
            'status'=> false,
        ];

        return $feedback;
    }

    public function tbkEdit($tbkID)
    {
        $data = tbk::find($tbkID);
        return response()->json($data);
    }

    public function tbkUpdate($tbkID, Request $req)
    {
        $this->validate($req,[
            'numberTbk'=>'required',
            'spj_id'=>'required|numeric'
        ]);

        $number_tbk = $req->numberTbk;
        $id_spj = $req->spj_id;

        $tbkModel = tbk::find($tbkID);
        $tbkModel->number_tbk = $number_tbk;
        $tbkModel->spj_id = $id_spj;
        if($tbkModel->save()){
          //  $req->session()->flash('message_success', 'Tbk Berhasil Diubah');
           // return redirect('tbk/'.$spj_id.'/list');
            $feetback = [
                'status'=> true,
                'numberTbk'=>$number_tbk
            ];

            return $feetback;
        }

        //$req->session()->flash('message_fails', 'Tbk Gagal diubah');
        //return redirect('tbk/'.$spj_id.'/create');
        $feetback = [
            'status'=> false,
        ];

        return $feetback;

    }

    public function tbkDelete($tbkID, Request $req)
    {
        $tbkModel = tbk::find($tbkID);
        if($tbkModel->delete()){
           // $req->session()->flash('message_success', 'Tbk Berhasil Dihapus');
            $feetback = [
                'status'=> true
            ];
            return $feetback;
        }
        //$req->session()->flash('message_fails', 'Tbk Gagal dihapus');
        $feetback = [
            'status'=> false
        ];
        return $feetback;
    }

}
