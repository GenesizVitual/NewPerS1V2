<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\UserInfo as info;

use Carbon\Carbon;

use Session;
class InfoController extends Controller
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



    public function getMessage(){
        $master = Session::get('user_id');
        $pesan_yg_belum_dibaca= info::where('user_id', $master)->where('status_baca','0')->count('id');
        $pesan_model = info::select('*', DB::raw('date(created_at) as tgl'))->where('user_id', $master)->where(function($query){
            $query->where('status_baca','0');
            $query->orWhere('status_baca','1');
        })->orderBy('created_at','DESC')->limit(10)->get();

        $pesan ="";

        foreach ($pesan_model as $isi){
            $tgl_exp =explode('-',$isi->tgl);
            $data_tgl  = Carbon::create($tgl_exp[0],$tgl_exp[1],$tgl_exp[2]);
            $tgl_detik = $data_tgl->subSecond();
            $tgl_menute = $data_tgl->subHour()->format('d-m-Y H:i:s');
            $tgl_jam = $data_tgl->subHour();

            $tgl_hari = $data_tgl->subHour();
            $tgl_bulan = $data_tgl->subMonth();
            $tgl_years = $data_tgl->subYear();

            $pesan.="<ul class='menu'><li><a href='#' onclick='readMessage(".$isi->id.")'><h4>Support Team<small><i class='fa fa-clock-o'></i>".$tgl_menute."</small></h4><p>".substr($isi->msg,0,35)."..."."</p></a></li></ul>";
        }

        $array = [
            'banyak_pesan'=> $pesan_yg_belum_dibaca,
            'pesan' => $pesan
        ];

        return response()->json($array);

    }

    public function getMessages($id){
        $model_user = info::find($id);
        $model_user->status_baca=1;
        $pesan = $model_user->msg;
        if($model_user->save()){
            $array = [
                'pesan' => $pesan
            ];
            return response()->json($array);
        }
    }

    public function superadmin_kirim_pesan_ke_pengguna($user_id)
    {
        $data_pesan = info::all()->where('user_id', $user_id);
        $data = [
            'data_pesan' => $data_pesan,
            'user_id'=> $user_id
        ];
        return view('content_superadmin.pesan.view', $data);
    }

    public function halaman_pesan($user_id)
    {
        $data = [
            'user_id'=> $user_id
        ];
        return view('content_superadmin.pesan.new', $data);
    }

    public function store_pesan(Request $req)
    {
        $this->validate($req,[
            'msg'=> 'required'
        ]);

        $pesan = $req->msg;
        $user_id = $req->user_id;

        $model = new info();
        $model->msg = $pesan;
        $model->user_id = $user_id;

        if($model->save()){
            $req->session()->flash('message_success','Pesan berhasil Di kirim');
            return redirect('pesan/'.$user_id);
        }

        $req->session()->flash('message_error','Pesan gagal Di kirim');
        return redirect('pesan/'.$user_id);
    }

    public function delete_pesan(Request $req, $id)
    {
        $model = info::find($id);
        if($model->delete()){
            $req->session()->flash('message_success','Pesan berhasil Di batalkan');
            return redirect('pesan/'.$model->user_id);
        }
        $req->session()->flash('message_success','Pesan berhasil Di batalkan');
        return redirect('pesan/'.$model->user_id);
    }
}
