<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Program as program;

use App\Keg as keg;

use Session;

use Redirect;

class KegController extends Controller
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



    public function keg_list($id)
    {
        $pass = array(
            'kegList'=>keg::all()->where('program_id', $id)->whereIn('user_id', Session::get('user_id')),
            'program'=>program::find($id)
        );
        return view('content.page_spjTbk.index', $pass);
    }

    public function createkeg($id)
    {
        $pass = array(
            'keg'=>keg::find($id)
        );

        return view('content.page_spjKeg.new', $pass);
    }

    public function kegStore($id,Request $req)
    {
        $this->validate($req,[
            'numberKeg'=>'required',
			 'nameKeg'=>'required'
        ]);

        $program_id = $id;
        $number_keg = $req->numberKeg;
		$name_keg = $req->nameKeg;


        $kegModel = new keg([
            'number_keg'=>$number_keg,
			'keg_name'=>$name_keg,
            'program_id' => $program_id,
            'user_id'=> Session::get('user_id')
        ]);

        if($kegModel->save()){
            //$req->session()->flash('message_success', 'Tbk Berhasil Dibuatkan');
            //return redirect('tbk/'.$spj_id.'/list');
            $feedback = [
                'status'=> true,
                'number_keg'=> $number_keg
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

    public function kegEdit($kegID)
    {
        $data = keg::find($kegID);
        return response()->json($data);
    }

    public function kegUpdate($kegID, Request $req)
    {
        $this->validate($req,[
            'numberKeg'=>'required',
			'nameKeg'=>'required'
        ]);

        $number_keg = $req->numberKeg;
		$name_keg = $req->nameKeg;

        $kegModel = keg::find($kegID);
        $kegModel->number_keg = $number_keg;
		$kegModel->keg_name= $name_keg;
		
        if($kegModel->save()){
          //  $req->session()->flash('message_success', 'Tbk Berhasil Diubah');
           // return redirect('tbk/'.$spj_id.'/list');
            $feetback = [
                'status'=> true,
                'numberKeg'=>$number_keg,
				'nameKeg'=>$name_keg
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

    public function kegDelete($kegID, Request $req)
    {
        $kegModel = keg::find($kegID);
        if($kegModel->delete()){
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
