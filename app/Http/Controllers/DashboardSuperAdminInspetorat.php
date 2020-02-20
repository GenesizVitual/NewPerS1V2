<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardSuperAdminInspetorat extends Controller
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

    public function index(){
        return view('content_inspektorat.page_dashboard.dashboard');
    }
}
