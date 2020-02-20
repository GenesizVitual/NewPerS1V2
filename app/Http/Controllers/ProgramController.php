<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Program as program;

use App\Spj as spj;

use App\Keg as keg;

use App\Tbk as tbk;

use App\Fiscal_years as tahun_anggaran;

use App\Dpa as dpa;

use App\Instance as instansi;

use App\Province as provinsi;

use App\Authorized as berwanang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Redirect;

class ProgramController extends Controller
{
    //============================================== SPJ ===============================================================

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



    public function index(Request $req)
    {

        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();

        $tahun_anggaran_models= tahun_anggaran::all()->where('user_id', Session::get('user_id'));

		if(!empty($tahun_anggaran_model)){
        
		$jumlah_total_program_per_keg = DB::table('keg')->select('keg.program_id',DB::raw('sum(belanja.total_price) as totalProgram'))->join('belanja','keg_id','=','keg.id')->where('keg.user_id',  Session::get('user_id'))->whereYear('keg.created_at',$tahun_anggaran_model->years )->groupBy('keg.program_id')->get();
        
		$dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
        
		$jumlah_total_keg_per_belanja = DB::table('keg')->join('belanja','keg_id','=','keg.id')->whereYear('belanja.created_at',$tahun_anggaran_model->years)->where('keg.user_id',  Session::get('user_id'))->sum('belanja.total_price');

        if(empty($dpa_model)){
            $req->session()->flash('message_fail','Buatlah terlebih dahulu DPA anda sesuai dengan tahun anggaraan yg aktif');
            return redirect('dpa');
        }
		
		$pass=array(
            'listProgram'=>program::where('user_id', Session::get('user_id'))->where('dpa_id',$dpa_model->id)->get(),
            'keg' => keg::where('user_id', Session::get('user_id'))->where('number_keg','like','%'.$tahun_anggaran_model->years.'%')->get(),
            'program'=>'active',
            'totals_program' => $jumlah_total_program_per_keg,
            'jumlah_keg' => $jumlah_total_keg_per_belanja,
            'dpa'=>$dpa_model,
            'tahun_anggaran'=> $tahun_anggaran_models
        );
       //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));
			
        return view('content2.page_program.index', $pass);
        }else{
            $pass=array(
                'listProgram'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null,
                'tahun_anggaran'=> null
				//'thn_anggaran' => tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
            );
            return view('content2.page_program.index', $pass);
        }
    }

    public function create()
    {
        return view('content2.page_program.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            
			'accountPROG'=>'required',
			'namePROG'=>'required',
			'dpa_id'=>'required',
            'fiscal_years_id'=> 'required'
        ]);

        $accountPROG = $req->accountPROG;
		$namePROG = $req->namePROG;
		$dpa_id = $req->dpa_id;
		$fiscal_years_id = $req->fiscal_years_id;

		
        $programModel = new program([
            'account_code'=> $accountPROG,
			'program_name'=> $namePROG,
			'dpa_id'=> $dpa_id,
			'fiscal_years_id'=> $fiscal_years_id,
            'user_id'=> Session::get('user_id')
        ]);

        if($programModel->save())
        {
            $req->session()->flash('message_success', 'Data Program telah dibuat');
            return redirect('program');
        }

        $req->session()->flash('message_fails', 'Data Program telah dibuat');
        return redirect('program/create');
    }

    public function edit($id)
    {
        $pass = array(
            'program' => program::find($id)
        );

       // return view('content.page_spjPenerimaan.edit', $pass);
        return response()->json($pass);
    }
	 
	public function update($id,Request $req)
    {
        $this->validate($req,[
            'numberPROGRAM'=>'required',
			'namePROGRAM'=>'required',
            'fiscal_years_id'=> 'fiscal_years_id'
        ]);

        $numberPROGRAM = $req->numberPROGRAM;
		$namePROGRAM = $req->namePROGRAM;
		$fiscal_years_id = $req->fiscal_years_id;


        $programModel = program::find($id);
        $programModel->account_code = $numberPROGRAM;
		$programModel->program_name = $namePROGRAM;
		$programModel->fiscal_years_id= $fiscal_years_id;
        if($programModel->save())
        {
            $feetback = [
              'status'=>true,
              'account_code' => $numberPROGRAM,
			  'program_name' => $namePROGRAM
            ];
            return $feetback;
        }

        $feetback =[
          'status' => false
        ];

        return $feetback;
    }
	
	public function delete($id, Request $req){
        $programModel = program::find($id);
        $no_program = $programModel->account_code;
        if($programModel->delete())
        {
            //$req->session()->flash('message_success', 'Surat Perjanjian Sudah dihapus');
            //return redirect('goodsreceipt');
            $feedback = [
                'status'=> true,
                'no_program'=>$no_program
            ];
            return $feedback;
        }
        //$req->session()->flash('message_fails', 'Surat Perjanjian gagal dihapus');
        //return redirect('goodsreceipt');
        $feedback = [
            'status'=> false,
            'no_program'=>$no_program
        ];
        return $feedback;
    }

    public function singkronDPA(Request $req)
    {
        $tahun_anggaran = tahun_anggaran::where('status',1)->where('user_id', Session::get('user_id'))->first();
        if(empty($tahun_anggaran->id)){
            $data=[
                'info'=>'Tahun Anggaran Belum Diaktifkan',
                'status'=> '',
            ];
            return response()->json($data);
        }
        $model_dpa = dpa::where('fiscal_years_id',$tahun_anggaran->id)->where('user_id', Session::get('user_id'))->count();
        if($model_dpa > 0){
            $dpa = dpa::where('fiscal_years_id',$tahun_anggaran->id)->where('user_id', Session::get('user_id'))->first();
            $belanja = DB::table('program')->
                join('keg','program.id','=','keg.program_id')->
                join('belanja','belanja.keg_id','=','keg.id')->
                where('program.fiscal_years_id', $tahun_anggaran->id)->
                where('program.user_id', Session::get('user_id'))->
                select(DB::raw('SUM(belanja.total_price) as total_belanja'))->
                first();
            $dpa->pagu_value = $belanja->total_belanja;
            if($dpa->save()){
                $data=[
                    'info'=>'Data Belanja Program dan Kegiatan Sudah Disinkronkan',
                    'status'=> 'success',
                ];
                return response()->json($data);
            }
        }else{
            $dpa = new dpa();
            $belanja = DB::table('program')->
            join('keg','program.id','=','keg.program_id')->
            join('belanja','belanja.keg_id','=','keg.id')->
            where('program.fiscal_years_id', $tahun_anggaran->id)->
            where('program.user_id', Session::get('user_id'))->
            select(DB::raw('SUM(belanja.total_price) as total_belanja'))->
            first();
            $dpa->pagu_value = $belanja->total_belanja;
            $dpa->fiscal_years_id = $tahun_anggaran->id;
            if($dpa->save()){
                $data=[
                    'info'=>'Data Belanja Program dan Kegiatan Sudah Disinkronkan',
                    'status'=> 'success',
                ];
                return response()->json($data);
            }
        }
    }


}
