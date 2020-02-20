<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Spj as spj;

use App\Tbk as tbk;

use App\Fiscal_years as tahun_anggaran;

use App\Dpa as dpa;

use App\Instance as instansi;

use App\Province as provinsi;

use App\Authorized as berwanang;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Redirect;

class SpjController extends Controller
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


    public function index()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
        $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','goodreceipt.tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('goodreceipt.dateOfpurchase',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();

            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
        $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')
           ->join('spj','spj.id','=','tbk.spj_id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
        $pass=array(
            'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
            'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
            'spj'=>'active',
            'totals_spj' => $jumlah_total_tbk_per_spj,
            'jumlah_spj' => $jumlah_per_spj,
            'dpa'=>$dpa_model
        );
       //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));

        return view('content2.page_spjPenerimaan.index', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content2.page_spjPenerimaan.index', $pass);
        }
    }

    public function create()
    {
        return view('content.page_spjPenerimaan.new');
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'numberSPJ'=>'required'
        ]);

        $numberSPJ = $req->numberSPJ;

        $spjModel = new spj([
            'number_spj'=> $numberSPJ,
            'user_id'=> Session::get('user_id')
        ]);

        if($spjModel->save())
        {
            $req->session()->flash('message_success', 'Surat Perjanjian No'.$numberSPJ.' telah dibuat');
            return redirect('goodsreceipt');
        }

        $req->session()->flash('message_fails', 'Surat Perjanjian No'.$numberSPJ.' gagal dibuat');
        return redirect('goodsreceipt/create');
    }

    public function edit($id)
    {
        $pass = array(
            'spj' => spj::find($id)
        );

       // return view('content.page_spjPenerimaan.edit', $pass);
        return response()->json($pass);
    }

    public function update($id,Request $req)
    {
        $this->validate($req,[
            'numberSPJ'=>'required'
        ]);

        $numberSPJ = $req->numberSPJ;

        $spjModel = spj::find($id);
        $spjModel->number_spj = $numberSPJ;
        if($spjModel->save())
        {
            $feetback = [
              'status'=>true,
              'no_spj' => $numberSPJ
            ];
            return $feetback;
        }

        $feetback =[
          'status' => false
        ];

        return $feetback;
    }

    public function delete($id, Request $req){
        $spjModel = spj::find($id);
        $no_spj = $spjModel->number_spj;
        if($spjModel->delete())
        {
            //$req->session()->flash('message_success', 'Surat Perjanjian Sudah dihapus');
            //return redirect('goodsreceipt');
            $feedback = [
                'status'=> true,
                'no_spj'=>$no_spj
            ];
            return $feedback;
        }
        //$req->session()->flash('message_fails', 'Surat Perjanjian gagal dihapus');
        //return redirect('goodsreceipt');
        $feedback = [
            'status'=> false,
            'no_spj'=>$no_spj
        ];
        return $feedback;
    }

    public function report_spj()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));

            return view('content2.report.report_rekaputulasi_content', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content2.report.report_rekaputulasi_content', $pass);
        }
    }

    public function report_spj_print(Request $req)
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $tanggal_cetak = $req->tanggal_cetak;
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));
            $instansi = instansi::where('user_id', Session::get('user_id'))->first();
            $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
            $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
            $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model,
                'instansi'=> $instansi, 'zona'=> $wilaya,
                'atasan_langsung'=> $atasan_langsung,
                'penyimpan_barang'=> $penyimpan_barang,
                'tahun_anggaran' => $tahun_anggaran_model->years,
                'tgl_cetak'=>$tanggal_cetak
            );

            return view('content2.report.report_rc', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content2.report.report_rc', $pass);
        }
    }

    //======================== Print Inspektorat =============================================================

    public function report_spj_inspektorat()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));

            return view('content_pInspektorat.report.report_rekaputulasi_content', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content_pInspektorat.report.report_rekaputulasi_content', $pass);
        }
    }

    public function report_spj_inspektorat_print()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));
            $instansi = instansi::where('user_id', Session::get('user_id'))->first();
            $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
            $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
            $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model,
                'instansi'=> $instansi, 'zona'=> $wilaya,
                'atasan_langsung'=> $atasan_langsung,
                'penyimpan_barang'=> $penyimpan_barang,
                'tahun_anggaran' => $tahun_anggaran_model->years
            );

            return view('content2.report.report_rc', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content2.report.report_rc', $pass);
        }
    }

    //======================== Print Bpk =============================================================

    public function report_spj_Bpk()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));

            return view('content_pbpk.report.report_rekaputulasi_content', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content_pbpk.report.report_rekaputulasi_content', $pass);
        }
    }

    public function report_spj_bpk_print()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));
            $instansi = instansi::where('user_id', Session::get('user_id'))->first();
            $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
            $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
            $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model,
                'instansi'=> $instansi, 'zona'=> $wilaya,
                'atasan_langsung'=> $atasan_langsung,
                'penyimpan_barang'=> $penyimpan_barang,
                'tahun_anggaran' => $tahun_anggaran_model->years
            );

            return view('content2.report.report_rc', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content2.report.report_rc', $pass);
        }
    }

    public function report_spj_inspektorat_pemkot()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));

            return view('content_pInspektorat_pemkot.report.report_rekaputulasi_content', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content_pInspektorat_pemkot.report.report_rekaputulasi_content', $pass);
        }
    }

    public function report_spj_inspektorat_pemkab()
    {
        $tahun_anggaran_model= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        if(!empty($tahun_anggaran_model)){
            $jumlah_total_tbk_per_spj = DB::table('tbk')->select('tbk.spj_id',DB::raw('sum(goodreceipt.totalPrice) as totalSJP'))->join('goodreceipt','tbk_id','=','tbk.id')->where('tbk.user_id',  Session::get('user_id'))->whereYear('tbk.created_at',$tahun_anggaran_model->years )->groupBy('tbk.spj_id')->get();
            $dpa_model=dpa::where('fiscal_years_id',$tahun_anggaran_model->id)->first();
            $jumlah_per_spj = DB::table('tbk')->join('goodreceipt','tbk_id','=','tbk.id')->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('tbk.user_id',  Session::get('user_id'))->sum('goodreceipt.totalPrice');
            $pass=array(
                'listSpj'=>spj::where('user_id', Session::get('user_id'))->where('number_spj','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'tbk' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_model->years.'%')->get(),
                'spj'=>'active',
                'totals_spj' => $jumlah_total_tbk_per_spj,
                'jumlah_spj' => $jumlah_per_spj,
                'dpa'=>$dpa_model
            );
            //  dd($jumlah_total_tbk_per_spj->where('spj_id', 1)->sum('totalPrice'));

            return view('content_pInspektorat_pemkab.report.report_rekaputulasi_content', $pass);
        }else{
            $pass=array(
                'listSpj'=>null,
                'tbk' => null,
                'spj'=>'active',
                'totals_spj' => null,
                'jumlah_spj' => null,
                'dpa'=>null
            );
            return view('content_pInspektorat_pemkab.report.report_rekaputulasi_content', $pass);
        }
    }
}
