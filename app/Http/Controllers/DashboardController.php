<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Session;

use App\Fiscal_years as tahun_anggaran;

use App\Warehouse as barang;

use App\Goodreceipt as penerimaan_barang;

use App\Expenditures as pengeluaran_barang;

use App\StockGoods as stok_barang;

use Redirect;

use App\UserInfo as info_user;

use Carbon\Carbon;

use App\Langganan as langganan;


class DashboardController extends Controller
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

        //$this->informasi();
        $tahun_anggaran_model = tahun_anggaran::where('status','1')->where('user_id', Session::get('user_id'))->first();
        if(!empty($tahun_anggaran_model->years)){
            $hitung_jumlah_barang = barang::where('user_id', Session::get('user_id'))->count();
            $hitung_total_penerimaan = penerimaan_barang::where('user_id', Session::get('user_id'))->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->sum('totalPrice');
            $pengeluaran_collection = DB::table('expenditures')
                ->join('goodreceipt','goodreceipt.id','=','expenditures.goodreceipt_id')
                ->select(DB::raw('sum(goodreceipt.unitPrice*expenditures.exit_item) as hasil_total_pengeluaran'))
                ->whereYear('expenditures.out_date', $tahun_anggaran_model->years)
                ->where('goodreceipt.user_id', Session::get('user_id'))->get();

            $ambil_data_barang = barang::all()
                                 ->where('user_id', Session::get('user_id'));

            $no=1;
            $colum=[];
            foreach ($ambil_data_barang as $key => $value)
            {

                $data_penerimaan = $value->goodMannyReceipt;
                $sisa_stok =0;
                foreach ($data_penerimaan as $data_stok_penerimaan)
                {
                    $amoun_of_goods = $data_stok_penerimaan->amountOfgoods;
                    $sisa_stok += $amoun_of_goods - $data_stok_penerimaan->getExpendures->sum('exit_item');
                }

                $row=[];
                $row[]=$no++;
                $row[]=$value->goods_name.'  '. $value->specs.'  '. $value->brand.'  '. $value->unit;
                $row[]=number_format($sisa_stok,2,',','.');
                $colum[] = $row;
            }

            $kirim_ke_halaman_dashboard= [
                'jumlah_barang'=> $hitung_jumlah_barang,
                'total_penerimaan'=>$hitung_total_penerimaan,
                'total_pengeluaran'=>$hitung_total_penerimaan-$this->get_new_stok_opname()['total_seluruh_stok'],
                'daftar_stok'=> $colum,
                'tahun_pengeluaran' => $tahun_anggaran_model->years
            ];
            return view('content2.dashboard.dashboard', $kirim_ke_halaman_dashboard);
        }else{
            $kirim_ke_halaman_dashboard= [
                'jumlah_barang'=> 0,
                'total_penerimaan'=>0,
                'total_pengeluaran'=>0,
                'daftar_stok'=> null,
                'tahun_pengeluaran' => $tahun_anggaran_model
            ];
            return view('content2.dashboard.dashboard', $kirim_ke_halaman_dashboard);
        }

    }

    public function get_new_stok_opname(){
        $tahun_anggaran = tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();

        $data_penerimaan = penerimaan_barang::where('user_id', Session::get('user_id'))->whereYear('dateOfpurchase',$tahun_anggaran->years)->get();
        $container=array();
        $seluruh_stok=0;
        $no=1;
        foreach ($data_penerimaan as $data_penerimaan)
        {
            $row = array();
            $stok = $data_penerimaan->amountOfgoods - $data_penerimaan->getExpendures->sum('exit_item');
            if($stok !=0){
                $row[]=  $no++;
                $row[]=  $data_penerimaan->getGoods->goods_name.', '.$data_penerimaan->specs;
                $row[]=  $data_penerimaan->getGoods->unit;
                $row[]=  $data_penerimaan->getGoods->brand;
                $row[]=  $stok;
                $row[]=  number_format($data_penerimaan->unitPrice,2,',','.');
                $row[]=  number_format($stok*$data_penerimaan->unitPrice,2,',','.');
                $row[]=  number_format($stok*$data_penerimaan->unitPrice,2,',','.');
                if($stok ==0 ){
                    $ket = "Barang tidak tersedia";
                }else{
                    $ket = "Barang masih tersedia";
                }
                $row[]=$ket;
                $seluruh_stok +=$stok*$data_penerimaan->unitPrice;
                $container[] = $row;
            }
        }
        $output = array('data'=> $container,'total_seluruh_stok'=>$seluruh_stok);
        return $output;
    }

    public function informasi(Request $request)
    {

       $model_langganan = langganan::all()->where('user_id', Session::get('user_id'))->where('status_aktif','1')->first();
       if(!empty($model_langganan->id)){
           $tgl_sekarang = Carbon::now();
           $tanggal_mulai = $tgl_sekarang->toDateString();
           $tanggal_akhir = $model_langganan->end_date;
           if($tanggal_mulai >= $tanggal_akhir){
               $json =  [
                   'informasi' => "Massa Aktif Anda Sudah berakhir",
                   'status_aktif' => false,
               ];
               $request->session()->put("status_aktif","false");
               return response()->json($json);
           }else if($tanggal_mulai <= $tanggal_akhir){
               $json =  [
                   'informasi' => "Massa Aktif Anda Masih Belum Berakhir",
                   'status_aktif' => true,
               ];
               $request->session()->put("status_aktif","true");
               return response()->json($json);
           }

       }else{
           $model_penerimaan = penerimaan_barang::where('user_id', Session::get('user_id'))->count('id');
           if($model_penerimaan >= 100)
           {
               $json =  [
                   'informasi' => "Batas Penginputan dimasa trial anda telah berakhir",
                   'status_aktif' => false,
               ];
               $request->session()->put("status_aktif","false");
           }else{
               $json =  [
                   'informasi' => "Anda masih menggunakan versi trial",
                   'status_aktif' => true,
               ];
               $request->session()->put("status_aktif","true");
           }
            return response()->json($json);
       }

    }

}