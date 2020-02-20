<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use App\Mutasi as mutasi;

use App\StockGoods;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Session;

use Validation;

use App\Warehouse as gudang;

use App\Goodreceipt as penerimaan;

use App\Sector as sector;

use App\Expenditures as pengeluaran;

use App\Instance as instansi;

use App\Province as provinsi;

use App\Authorized as berwanang;

use App\StockGoods as stok_barang;

use App\Fiscal_years as tahun_anggaran;

use App\Spj as spj;

use Redirect;




class ExpenduresController extends Controller
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

    public function index()
    {
        $pass=array(
            'gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')),
            'bidang'=> sector::all()->whereIn('user_id', Session::get('user_id'))
        );

      return view('content2.page_expedures.index', $pass);
    }

//    public function get_receipt($id_goods){
//        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
//
//        $data =penerimaan::
//                where('warehouse_id', $id_goods)
//                ->where('user_id', Session::get('user_id'))->whereYear('dateOfpurchase', $tahun_anggaran_aktiv->years )->orderBy('dateOfpurchase','desc')->get();
//
//        $sisa_stok =0;
//        $status_stok = false;
//        if(count($data) == 0 ){
//            $data =penerimaan::where('warehouse_id', $id_goods)
//                ->where('user_id', Session::get('user_id'))->orderBy('dateOfpurchase','decs')->get();
//          //  dd($data);
//        }else {
//            $status_stok = true;
//           $stok_barang = stok_barang::where('warehouse_id', $id_goods)->first();
//            if (!empty($stok_barang->stock)) {
//                $sisa_stok = $stok_barang->stock;
//            } else {
//                $sisa_stok = 0;
//            }
//
//        }
//
//
//        $no =1;
//        $no2 =1;
//        $container = array();
//        $nama_barang='';
//        $specs="";
//        $filterjumlah=null;
//        $batas_stok = 0;
//        foreach ($data  as $key=> $row){
//            $ambil_sisa_di_stok_dimutasi = mutasi::where('goodreceipt_id', $row->id)->first();
//            $jumlah_total  = $row->amountOfgoods-$row->getExpendures->where('goodreceipt_id', $row->id)->sum('exit_item');
//
//
//            if($status_stok==true){
//                $cek_data_penerimaan_awal = penerimaan::where('warehouse_id', $row->warehouse_id)->orderBy('id')->first();
//                $cek_jumlah_stok_diawal = $cek_data_penerimaan_awal->getExpendures->sum('exit_item');
//                // dd($cek_data_penerimaan_awal->getExpendures);
//                $ambil_data_id_yg_bukan_sisa_lama = penerimaan::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))->count();
//                $rows_id = $ambil_data_id_yg_bukan_sisa_lama-1;
//                $datanya = penerimaan::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))->orderBy('created_at','desc')->skip($rows_id)->take($rows_id)->first();
//
//                $sisa_stok-=$cek_jumlah_stok_diawal;
//
//           }
//
//            $sisa_total_stok = $sisa_stok+$jumlah_total;
//
//            $batas_stok = $sisa_stok - $row->getExpendures->where('goodreceipt_id', $row->id)->sum('exit_item');
//            $column = array();
//            $tanggal_filter="";
//            if(round($sisa_total_stok) != 0){
//
//                $column[] =  $no++;
//                if($batas_stok >  0 && $batas_stok <= $sisa_total_stok) {
//                    $tanggal_filter =date('d-m-Y', strtotime($stok_barang->tgl_akhir_catatan));
//                    $column[] = date('d-m-Y', strtotime($stok_barang->tgl_akhir_catatan));
//                    $column[] = '<a href="'.url('goodreceipt/'.$datanya->tbk_id.'/list').'" tooltip="liat tbk">'.$row->getGoods->goods_name . ' | ' . $row->getGoods->specs .' | '. $row->getGoods->unit .' | '.$row->getGoods->brand.'</a>';
//                    $column[] = number_format($batas_stok, 2, ',', '.');
//                    $column[] = number_format($stok_barang->harga_satuan_stok, 2, ',', '.');
//                    $column[] = $row->getSupplier->suppliers."=====";
//                    $sisa_total_stok = $batas_stok;
//                }else{
//                    $tanggal_filter =date('d-m-Y', strtotime($row->dateOfpurchase));
//                    $column[] = date('d-m-Y', strtotime($row->dateOfpurchase));
//                    $column[] = '<a href="'.url('goodreceipt/'.$row->tbk_id.'/list').'" tooltip="liat tbk">'.$row->getGoods->goods_name . ' | ' . $row->getGoods->specs .' | '. $row->getGoods->unit .' | '.$row->getGoods->brand.'</a>';
//                    //$column[] = number_format($batas_stok, 2, ',', '.');
//                    $column[] = number_format($sisa_total_stok, 2, ',', '.');
//                    $column[] = number_format($row->unitPrice, 2, ',', '.');
//                    $column[] = $row->getSupplier->suppliers."====+";
//                }
//
//                if(!empty($filterjumlah)){
//                    $button_keluarkan = '<button  class="btn btn-primary" style="margin: 5px" disabled>Habiskan stok barang lama</button>';
//                    $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures('.$row->id.')"> Lihat</button>';
//                    $column[] = $button_keluarkan.''.$button_lihat;
//                }
//                else
//                if($sisa_total_stok ==0){
//                    $button_keluarkan = '<button  class="btn btn-primary" style="margin: 5px" disabled> Stok barang habis </button>';
//                    $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures('.$row->id.')"> Lihat</button>';
//
//                    $column[] = $button_keluarkan.''.$button_lihat;
//                }else{
//                    if($batas_stok >  0 && $batas_stok <= $sisa_total_stok){
//                        $button_keluarkan = '<input name="tgl_stok_lama" type="hidden" value="'.$tanggal_filter.'"> <button  class="btn btn-danger" style="margin: 5px" onclick="exit_item('.$datanya->id.','.$id_goods.','.$sisa_total_stok.')"> Stok Lama Masih Tersedia</button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures('.$row->id.')"> Lihat</button>';
//                        $column[] = $button_keluarkan."".$button_lihat;
//                    }else{
//                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="'.$tanggal_filter.'"><button  class="btn btn-primary" style="margin: 5px" onclick="exit_item('.$row->id.','.$id_goods.','.$sisa_total_stok.')"> Keluarkan </button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures('.$row->id.')"> Lihat</button>';
//                        $column[] = $button_keluarkan."".$button_lihat;
//                    }
//                }
//
//                $filterjumlah = $sisa_total_stok;
//                $container[]= $column;
//                $nama_barang= $row->getGoods->goods_name;
//                $specs= $row->getGoods->specs;
//            }
//            $sisa_stok=0;
//
//        }
//        $output = array('data'=>$container,'barang'=>$nama_barang,'specs'=> $specs);
//        return response()->json($output);
//    }


//    public function get_receipt_stok($id_goods){
//        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
//        $tahun_paling_tua =  tahun_anggaran::where('user_id', Session::get('user_id'))->orderBy('years','asc')->first();
//
//        $batas_stok = stok_barang::where('fiscal_years_id', $tahun_anggaran_aktiv->id)->where('warehouse_id', $id_goods)
//        ->where('user_id', Session::get('user_id'))->first()->stock;
//
//
//
//        $pengeluaran_barang = pengeluaran::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))->
//            whereYear('out_date', $tahun_anggaran_aktiv->years)->sum('exit_item');
//        if(($batas_stok - $pengeluaran_barang) >= 0 ){
//            $batas_stok = 0;
//        }else{
//            $batas_stok = $batas_stok - $pengeluaran_barang;
//        }
//
//        $data_penerimaans =penerimaan::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))
//            ->whereYear('dateOfpurchase', $tahun_anggaran_aktiv->years )->get();
//
//        $cek_saldo = $batas_stok-$pengeluaran_barang;
//
//        if(($cek_saldo <= 0)){
//            $spj_stok = spj::where('number_spj','like','%'.'stokSpj/'.($tahun_paling_tua->years))->first();
//            $tbknya = $spj_stok->getTbk->first();
//            $barang_nya = $tbknya->getGoodReciept->where('warehouse_id', $id_goods)->first();
//            $data_penerimaan = penerimaan::where('tbk_id', $tbknya->id)->where('id', $barang_nya->id)->get();
//        }
//
//
//        $no=1;
//        $container = array();
//        $stok_penerimaan = 0;
//        $nama_barang = '';
//        $specs ='';
//        $tanggal_filter="";
//        $batas_stok_penerimaan = 0;
//
//        foreach ($data_penerimaan as $key=> $row){
//            $tanggal_filter =date('d-m-Y', strtotime($row->dateOfpurchase));
//            $stok_keluar = $row->getExpendures->where('goodreceipt_id', $row->id)->sum('exit_item');
//            $stok_penerimaan = $row->amountOfgoods-$stok_keluar;
//
//            $column = array();
//            if(round($stok_penerimaan) !=0) {
//                $column[] = $no++;
//                if ($batas_stok >= 0 && $batas_stok < $stok_penerimaan) {
//                    $column[] = date('d-m-Y', strtotime($row->dateOfpurchase));
//                    //$column[] = $row->getGoods->goods_name . ' | ' . $row->getGoods->specs . ' | ' . $row->getGoods->unit . ' | ' . $row->getGoods->brand ;
//                    $column[] = '<a href="'.url('goodreceipt/'.$row->tbk_id.'/list').'" tooltip="liat tbk">'.$row->getGoods->goods_name . ' | ' . $row->getGoods->specs .' | '. $row->getGoods->unit .' | '.$row->getGoods->brand.'</a>' ;
//                    $column[] = $stok_penerimaan;
//                    $column[] = number_format($row->unitPrice,2,',','.');
//                    $column[] = $row->getSupplier->suppliers ;
//                } else {
//                    if ($stok_penerimaan > 0) {
//                        $column[] = date('d-m-Y', strtotime($row->dateOfpurchase));
//                        $column[] = '<a href="'.url('goodreceipt/'.$row->tbk_id.'/list').'" tooltip="liat tbk">'.$row->getGoods->goods_name . ' | ' . $row->getGoods->specs .' | '. $row->getGoods->unit .' | '.$row->getGoods->brand.'</a>' ;
//                        $column[] = $stok_penerimaan;
//                        $column[] =  number_format($row->unitPrice,2,',','.');
//                        $column[] = $row->getSupplier->suppliers;
//                    }
//                }
//
//                if ($batas_stok >= 0 && $batas_stok < $stok_penerimaan) {
//                    $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button  class="btn btn-danger" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Stok lama masih tersedia </button>';
//                    $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                } else {
//                    if ($batas_stok_penerimaan > 0) {
//                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button disabled class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Keluarkan </button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" disabled onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                    }else{
//                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button  class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Keluarkan</button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                    }
//                }
//
//
//                $column[] = $button_keluarkan . "" . $button_lihat;
//
//                $batas_stok -= $pengeluaran_barang;
//
//
//                $container[] = $column;
//
//            }
//            $batas_stok_penerimaan = $stok_penerimaan;
//
//        }
//
//        if(!empty($container)){
//            $outputs= $container;
//        }else{
//            $outputs=$this->get_receiptBY($id_goods);
//        }
//
//        $output = array('data'=>$outputs,'barang'=>$nama_barang,'specs'=> $specs);
//        return response()->json($output);
//    }


    public function get_receipt($id_goods){

        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $tahun_paling_tua =  tahun_anggaran::where('user_id', Session::get('user_id'))->orderBy('years','asc')->first();

        $batas_stok = stok_barang::where('fiscal_years_id', $tahun_anggaran_aktiv->id)->where('warehouse_id', $id_goods)
        ->where('user_id', Session::get('user_id'))->first()->stock;

        $pengeluaran_barang = pengeluaran::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))->
            whereYear('out_date', $tahun_anggaran_aktiv->years)->sum('exit_item');
        if(($batas_stok - $pengeluaran_barang) >= 0 ){
            $batas_stok = 0;
        }else{
            $batas_stok = $batas_stok - $pengeluaran_barang;
        }

        $data_penerimaan =penerimaan::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))
                            ->whereRaw('year(dateOfpurchase)', [$tahun_anggaran_aktiv->years-2, $tahun_anggaran_aktiv->years])->orderBy('dateOfpurchase','asc')->get();

        $cek_saldo = $batas_stok-$pengeluaran_barang;



        $no=1;
        $container = array();
        $stok_penerimaan = 0;
        $nama_barang = '';
        $specs ='';
        $tanggal_filter="";
        $batas_stok_penerimaan = 0;

        foreach ($data_penerimaan as $key=> $row){
            $tanggal_filter =date('d-m-Y', strtotime($row->dateOfpurchase));
            $stok_keluar = $row->getExpendures->where('goodreceipt_id', $row->id)->sum('exit_item');
            $stok_penerimaan = $row->amountOfgoods-$stok_keluar;

            $column = array();
            if(round($stok_penerimaan) !=0) {
                $column[] = $no++;
                if ($batas_stok >= 0 && $batas_stok < $stok_penerimaan) {
                    $column[] = date('d-m-Y', strtotime($row->dateOfpurchase));
                    $column[] = '<a href="'.url('goodreceipt/'.$row->tbk_id.'/list').'" tooltip="liat tbk">'.$row->getGoods->goods_name . ' | ' . $row->getGoods->specs .' | '. $row->getGoods->unit .' | '.$row->getGoods->brand.'</a>' ;
                    $column[] = $stok_penerimaan;
                    $column[] =  number_format($row->unitPrice,2,',','.');
                    $column[] = $row->getSupplier->suppliers;
                } else {
                    if ($stok_penerimaan > 0) {
                        $column[] = date('d-m-Y', strtotime($row->dateOfpurchase));
                        $column[] = '<a href="'.url('goodreceipt/'.$row->tbk_id.'/list').'" tooltip="liat tbk">'.$row->getGoods->goods_name . ' | ' . $row->getGoods->specs .' | '. $row->getGoods->unit .' | '.$row->getGoods->brand.'</a>' ;
                        $column[] = $stok_penerimaan;
                        $column[] = number_format($row->unitPrice,2,',','.');
                        $column[] = $row->getSupplier->suppliers;
                    }
                }

                if ($batas_stok >= 0 && $batas_stok < $stok_penerimaan) {
                    if($batas_stok_penerimaan >0) {
                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button disabled class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Keluarkan </button>';
                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" disabled onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
                    }else{
                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button  class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Keluarkan </button>';
                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px"  onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
                    }
                } else {
//                    if ($batas_stok_penerimaan > 0) {
//                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button disabled class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Keluarkan </button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" disabled onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                    }
//                    else{
                        $button_keluarkan = '<input name="tgl_stok_baru" type="hidden" value="' . $tanggal_filter . '"><button  class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $stok_penerimaan . ')"> Keluarkan </button>';
                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                    }
                }


                $column[] = $button_keluarkan . "" . $button_lihat;

                $batas_stok -= $pengeluaran_barang;


                $container[] = $column;

            }
            $batas_stok_penerimaan = $stok_penerimaan;

        }

//        return $container;
        $outputs= $container;
        $output = array('data'=>$outputs,'barang'=>$nama_barang,'specs'=> $specs);
        return response()->json($output);
    }

//    public function get_receipt_habis($id_goods){
//        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
//        $data =penerimaan::
//        where('warehouse_id', $id_goods)
//            ->where('user_id', Session::get('user_id'))->whereYear('dateOfpurchase', $tahun_anggaran_aktiv->years )->orderBy('dateOfpurchase','asc')->get();
//        $sisa_stok =0;
//        $status_stok = false;
//        if(count($data) == 0 ){
//            $data =penerimaan::where('warehouse_id', $id_goods)
//                ->where('user_id', Session::get('user_id'))->orderBy('dateOfpurchase','desc')->get();
//        }else {
//            $status_stok = true;
//            $stok_barang = stok_barang::where('warehouse_id', $id_goods)->where('fiscal_years_id', $tahun_anggaran_aktiv->id)->first();
//            if (!empty($stok_barang->stock)) {
//                $sisa_stok = $stok_barang->stock;
//            } else {
//                $sisa_stok = 0;
//            }//
//        }
//
//
//        $no =1;
//        $no2 =1;
//        $container = array();
//        $nama_barang='';
//        $filterjumlah=null;
//        $specs="";
//        foreach ($data  as $key=> $row){
//            $ambil_sisa_di_stok_dimutasi = mutasi::where('goodreceipt_id', $row->id)->first();
//            $jumlah_total  = $row->amountOfgoods-$row->getExpendures->where('goodreceipt_id', $row->id)->sum('exit_item');
//
//            if($status_stok==true){
//                $cek_data_penerimaan_awal = penerimaan::where('warehouse_id', $row->warehouse_id)->orderBy('id')->first();
//                $cek_jumlah_stok_diawal = $cek_data_penerimaan_awal->getExpendures->sum('exit_item');
//
//                $sisa_stok-=$cek_jumlah_stok_diawal;
//            }
//
//            $sisa_total_stok = $sisa_stok+$jumlah_total;
//
//            $column = array();
//            if(round($sisa_total_stok) ==0) {
//                $tgl_penerimaan =date('d-m-Y', strtotime($row->dateOfpurchase));
//                $column[] = $no++;
//                $column[] = date('d-m-Y', strtotime($row->dateOfpurchase));
//                $column[] = $row->getGoods->goods_name . ' | ' . $row->getGoods->specs;
//                $column[] = number_format($sisa_total_stok, 2, ',', '.');
//                $column[] = number_format($row->unitPrice, 2, ',', '.');
//                $column[] = $row->getSupplier->suppliers;
//
//
//                if (!empty($filterjumlah) && round($filterjumlah)==0) {
//                    $button_keluarkan = '<button  class="btn btn-primary" style="margin: 5px" disabled>Stok barang habis</button>';
//                    $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                    $column[] = $button_keluarkan . '' . $button_lihat;
//                } else
//                    if (round($sisa_total_stok) == 0) {
//                        $button_keluarkan = '<button  class="btn btn-primary" style="margin: 5px" disabled> Stok barang habis </button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//
//                        $column[] = $button_keluarkan . '' . $button_lihat;
//                    } else {
//                        $button_keluarkan = '<button  class="btn btn-primary" style="margin: 5px" onclick="exit_item(' . $row->id . ',' . $id_goods . ',' . $sisa_total_stok . ')"> Keluarkan </button>';
//                        $button_lihat = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $row->id . ')"> Lihat</button>';
//                        $column[] = $button_keluarkan . "" . $button_lihat;
//                    }
//
//                $filterjumlah = $sisa_total_stok;
//                $container[] = $column;
//                $nama_barang = $row->getGoods->goods_name;
//                $specs = $row->getGoods->specs;
//            }
//            $sisa_stok = 0;
//
//        }
//        $output = array('data'=>$container,'barang'=>$nama_barang,'specs'=> $specs);
//        return response()->json($output);
//    }

    public function get_receipt_habis($id_goods){
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $tahun_paling_tua =  tahun_anggaran::where('user_id', Session::get('user_id'))->orderBy('years','asc')->first();

        $batas_stok = stok_barang::where('fiscal_years_id', $tahun_anggaran_aktiv->id)->where('warehouse_id', $id_goods)
            ->where('user_id', Session::get('user_id'))->first()->stock;

        $pengeluaran_barang = pengeluaran::where('warehouse_id', $id_goods)->where('user_id', Session::get('user_id'))->
        whereRaw('year(out_date)', [$tahun_anggaran_aktiv->years-2, $tahun_anggaran_aktiv->years])->groupBy('goodreceipt_id')->get();

        $container = array();

        $nama_barang = 'sebentar';
        $specs ='bentar';
        $no=1;
        foreach ($pengeluaran_barang as $key=> $data_penerimaan){
            $column = array();
            $jumlah_keluar_barang = $data_penerimaan->get_recept->amountOfgoods-$data_penerimaan->get_recept->getExpendures->sum('exit_item');
             if($jumlah_keluar_barang <= 0){
                $column[] =$no++;
                $column[] =date('d-m-Y', strtotime($data_penerimaan->get_recept->dateOfpurchase));
             //   $column[] =$data_penerimaan->get_recept->getGoods->goods_name;
                $column[] = '<a href="'.url('goodreceipt/'.$data_penerimaan->get_recept->tbk_id.'/list').'" tooltip="liat tbk">'.$data_penerimaan->get_recept->getGoods->goods_name.'</a>' ;

                $column[] =number_format($jumlah_keluar_barang, 2, ',', '.');
                $column[] =number_format($data_penerimaan->get_recept->unitPrice, 2, ',', '.');
                $column[] =$data_penerimaan->get_recept->getSupplier->suppliers;
                $button_keluarkan = '<button  class="btn btn-warning" style="margin: 5px" onclick="call_data_expendures(' . $data_penerimaan->get_recept->id . ')" > Lihat </button>';
                $column[] =$button_keluarkan.'';
                $container[] = $column;
            }
        }

        $output = array('data'=>$container,'barang'=>$nama_barang,'specs'=> $specs);
        return response()->json($output);
    }

    public function get_pengeluaran_base_bidang(Request $req){
        $this->validate($req,[
           'bidang' => 'required',
           'tgl_permintaan'=> 'required'
        ]);
       $id_bidang = $req->bidang;
        $tgl_bidang = date('Y-m-d', strtotime($req->tgl_permintaan));

        $data = pengeluaran::all()
            ->where('sector_id', $id_bidang)
            ->where('user_id', Session::get('user_id'))
            ->where('status_surat_permintaan', '0')
            ->where('out_date', $tgl_bidang)
            ->sortBy('out_date');

        $container = array();
        $id_barangs =array();
        $no=1;
        foreach ($data as $row){
            $colum = array();
            $colum[]=$no++;
            $colum[]= $row->get_sector->sector_name;
            $colum[]= $row->get_warehouse->goods_name.', '.$row->get_warehouse->specs;
            $colum[]= $row->exit_item;
            $colum[]= date('d-m-Y', strtotime($row->out_date));
            $id_barangs[]= $row->id;

            $container[] = $colum;
        }
        $output = array('data'=>$container,'id_barang'=>$id_barangs);
        return response()->json($output);
    }

    public function get_pengeluarans_base_bidang(Request $req){

        $this->validate($req,[
            'bidang' => 'required',
            'tgl_permintaan'=> 'required'
        ]);
        $id_bidang = $req->bidang;
        $tgl_bidang = date('Y-m-d', strtotime($req->tgl_permintaan));

        $data = pengeluaran::all()
            ->where('sector_id', $id_bidang)
            ->where('status_surat_permintaan', '1')
            ->where('status_surat_pengeluaran', '0')
            ->where('user_id', Session::get('user_id'))
            ->where('out_date', $tgl_bidang)
            ->sortBy('out_date');

        $container = array();
        $id_pengeluaran = array();
        $no=1;
        foreach ($data as $row){
            $colum = array();
            $colum[]=$no++;
            $colum[]= $row->get_sector->sector_name;
            $colum[]= $row->get_warehouse->goods_name.", ".$row->get_warehouse->specs;
            $colum[]= $row->exit_item;
            $colum[]= date('d-m-Y', strtotime($row->out_date));

            $container[] = $colum;
            $id_pengeluaran[] = $row->id;
        }
        $output = array('data'=>$container,'id_barang'=>$id_pengeluaran);
        return response()->json($output);
    }

    public function get_expendures($id_penerimaan){
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $data =pengeluaran::
            where('goodreceipt_id', $id_penerimaan)
//            ->where('user_id', Session::get('user_id'))->whereYear('out_date',$tahun_anggaran_aktiv->years)->orderBy('out_date','desc')->get();
            ->where('user_id', Session::get('user_id'))->orderBy('out_date','desc')->get();

        $container = array();
        $no=1;
        foreach ( $data as $row){
            $colum = array();
            $colum[] =$no++;
            $colum[] = date('d-m-Y',strtotime($row->out_date));
            $colum[] = $row->get_warehouse->goods_name.', '.$row->get_warehouse->specs;
            $colum[] =  $row->exit_item;
            $colum[] = $row->get_sector->sector_name;
            $colum[] = $row->information;
            $colum[] = '<button class="btn btn-danger" style="margin: 5px" onclick="recover_receipt('.$row->id.')"> Batalkan </button>';
            $container[]= $colum;
        }

        $output =  array('data'=> $container);
        return response()->json($output);
    }

    public function store(Request $req){

        $master_id = Session::get('user_id');

        $this->validate($req,[
            'out_date' => 'required',
            'goodreceipt_id' => 'required',
            'warehouse_id' => 'required',
            'exit_item' => 'required',
            'sector_id' => 'required',
        ]);

        $tanggal_barang_dikeluarkan = date('Y-m-d', strtotime($req->out_date));
        $id_penerimaan = $req->goodreceipt_id;
        $id_barang = $req->warehouse_id;
        $barang_keluar = $req->exit_item;
        $sector_id = $req->sector_id;
        $keterangan = $req->information;


        //isi data pengeluaran
        $pengeluaran_model = new pengeluaran([
            'out_date' => $tanggal_barang_dikeluarkan,
            'goodreceipt_id' => $id_penerimaan,
            'warehouse_id' => $id_barang,
            'exit_item' => $barang_keluar,
            'sector_id' => $sector_id,
            'information' => $keterangan,
            'user_id' => $master_id
        ]);

        //ambil stok di gudang
        $gudangModel= gudang::find($id_barang);
        $stok_gudang = $gudangModel->initial_stock;
        $harga_total = $gudangModel->total_price;



        //ambil harga penerimaan barang yang sesuai barang
        $penerimaan_model = penerimaan::find($id_penerimaan);
        $barang_penerimaan = $penerimaan_model->amountOfgoods;
        $stok_barang_di_gudang = $stok_gudang;
        $harga_penerimaan_barang = $penerimaan_model->unitPrice;
        $tanggal_penerimaan = $penerimaan_model->dateOfpurchase;

        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();

        $cek_tgl_stok_terakhir = StockGoods::where('warehouse_id',$penerimaan_model->warehouse_id)->where('user_id', Session::get('user_id'))->whereyear('tgl_akhir_catatan',$tahun_anggaran_aktiv->years-1)->first();


        $c_tanggal_penerimaan = date('Y-m-d', strtotime($penerimaan_model->dateOfpurchase));
        $c_tanggal_pengeluaran = date('Y-m-d', strtotime($req->out_date));

        if(!empty($cek_tgl_stok_terakhir->tgl_akhir_catatan)){
            $c_tanggal_akhir_stok = date('Y-m-d', strtotime($cek_tgl_stok_terakhir->tgl_akhir_catatan));
            if($c_tanggal_pengeluaran < $c_tanggal_akhir_stok){
                $feedback = array(
                    'status'=> false,
                    'info'=> 'Tanggal pengeluaran lebih kecil dari pada tanggal penerimaan'
                );
                return response()->json($feedback);
            }else {
                if(($c_tanggal_pengeluaran >= $c_tanggal_akhir_stok) or ($c_tanggal_pengeluaran >= $c_tanggal_akhir_stok)){

                    //hitung sisa total stok dan total harga setelah dikeluarkan
                    $sisa_stok = $stok_barang_di_gudang-$barang_keluar;
                    $sisa_harga = ($sisa_stok)* $harga_penerimaan_barang;

                    //proses tambah pengeluaran
                    if($pengeluaran_model->save()){

                        $gudangModel->initial_stock = $sisa_stok;
                        $gudangModel->total_price = $sisa_harga;
                        // $gudangModel->save();

                        $mutasi = new mutasi([
                            'tgl_transaksi' =>$tanggal_barang_dikeluarkan,
                            'warehouse_id' => $id_barang,
                            'goodreceipt_id'=>0,
                            'expenditures_id'=>$pengeluaran_model->id,
                            'last_stock' =>$stok_barang_di_gudang,
                            'jum_in'=>0,
                            'jum_out'=>$barang_keluar,
                            'remaining_stok'=>$sisa_stok,
                            'total_start'=>$barang_keluar*$harga_penerimaan_barang,
                            'total_final'=>$sisa_stok*$harga_penerimaan_barang,
                            'total'=>0,
                            'user_id'=> $master_id
                        ]);
                        $mutasi->save();

                        $feedback = array(
                            'status'=> true,
                            'info'=> 'Data Pengeluaran Berhasil disimpan'
                        );

                        return response()->json($feedback);
                    }
                }
            }
        }
        else if($c_tanggal_pengeluaran >= $c_tanggal_penerimaan ){

              //hitung sisa total stok dan total harga setelah dikeluarkan
            $sisa_stok = $stok_barang_di_gudang-$barang_keluar;
            $sisa_harga = ($sisa_stok)* $harga_penerimaan_barang;

            //proses tambah pengeluaran
            if($pengeluaran_model->save()){

                $gudangModel->initial_stock = $sisa_stok;
                $gudangModel->total_price = $sisa_harga;
                // $gudangModel->save();

                $mutasi = new mutasi([
                    'tgl_transaksi' =>$tanggal_barang_dikeluarkan,
                    'warehouse_id' => $id_barang,
                    'goodreceipt_id'=>0,
                    'expenditures_id'=>$pengeluaran_model->id,
                    'last_stock' =>$stok_barang_di_gudang,
                    'jum_in'=>0,
                    'jum_out'=>$barang_keluar,
                    'remaining_stok'=>$sisa_stok,
                    'total_start'=>$barang_keluar*$harga_penerimaan_barang,
                    'total_final'=>$sisa_stok*$harga_penerimaan_barang,
                    'total'=>0,
                    'user_id'=> $master_id
                ]);
                $mutasi->save();

                $feedback = array(
                    'status'=> true,
                    'info'=> 'Data Pengeluaran Berhasil disimpan'
                );

                return response()->json($feedback);
            }
        }


        $feedback = [
            'info' => 'Pengeluaran Barang Gagal, Perhatikan Tanggal Pengeluaran Harus Lebih besar atau sama dengan tanggal penerimaan',
            'status'=> false
        ];

        return response()->json($feedback);
    }

    public function recover_receipt($id_pengeluaran){

        //panggail model mutasi

        $pengeluaran_model = pengeluaran::find($id_pengeluaran);
        $penerimaan_model = penerimaan::find($pengeluaran_model->goodreceipt_id);
        $stok_barang_keluar = $pengeluaran_model->exit_item;
        $id_barang = $pengeluaran_model->warehouse_id;
        $mutasi_model=  mutasi::where('expenditures_id',$id_pengeluaran)->first();
        if($pengeluaran_model->delete()){

            $gundang_model= gudang::find($id_barang);
            $stok_gudang =$gundang_model->initial_stock;
            $total_harga_stok_gudang =$gundang_model->total_price;

            $gundang_model->initial_stock = $stok_gudang+$stok_barang_keluar;
            $gundang_model->total_price = $total_harga_stok_gudang+($stok_barang_keluar*$penerimaan_model->totalPrice);

//            if($gundang_model->update()){
//
//            }
            $mutasi_model->delete();

            $feedback = [
                'info' => 'Pengeluaran Barang Telah dihapus',
                'status'=> false,
                'goods'=>$id_barang
            ];

            return $feedback;
        }

    }

    public function laporan_pengeluaran_content(){
        $pass = array(
            'gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')),
        );
        return view('content2.page_expedures.report', $pass);
    }

    public function laporan_bpk_pengeluaran_content(){
        $pass = array(
            'gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')),
        );

        return view('content_pbpk.page_expedures.report', $pass);
    }

    public function laporan_pemprov_pengeluaran_content()
    {
        $pass = array(
            'gudang' => gudang::all()->whereIn('user_id', Session::get('user_id')),
        );
        return view('content_pInspektorat.page_expedures.report', $pass);
    }

    public function laporan_pemkot_pengeluaran_content()
    {
        $pass = array(
            'gudang' => gudang::all()->whereIn('user_id', Session::get('user_id')),
        );
        return view('content_pInspektorat_pemkot.page_expedures.report', $pass);
    }

    public function laporan_pemkab_pengeluaran_content()
    {
        $pass = array(
            'gudang' => gudang::all()->whereIn('user_id', Session::get('user_id')),
        );
        return view('content_pInspektorat_pemkab.page_expedures.report', $pass);
    }


    public function laporan_bph_content(){
        return view('content2.report.report_bph_content');
    }

    public function laporan_bpk_bph_content(){
        return view('content_pbpk.report.report_bph_content');
    }

    public function laporan_pemrov_bph_content(){
        return view('content_pInspektorat.report.report_bph_content');
    }

    public function laporan_pemkot_bph_content(){
        return view('content_pInspektorat_pemkot.report.report_bph_content');
    }
    public function laporan_pemkab_bph_content(){
        return view('content_pInspektorat_pemkab.report.report_bph_content');
    }

    public function laporan_semester(){
        return view('content2.report.report_semester_content');
    }

    public function laporan_semester_bpk(){
        return view('content_pbpk.report.report_semester_content');
    }

    public function laporan_semester_pemprov(){
        return view('content_pInspektorat.report.report_semester_content');
    }

    public function laporan_semester_pemkot(){
        return view('content_pInspektorat_pemkot.report.report_semester_content');
    }
    public function laporan_semester_pemkab(){
        return view('content_pInspektorat_pemkab.report.report_semester_content');
    }

    public function get_data_semester(){

       $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $no = 1;
        $no_urut = 1;
        $no_urut2 = 1;
        $container = array();

        $stok_model = DB::table('expenditures')
            ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
            ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
            ->where('expenditures.user_id', Session::get('user_id'))
            ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
            ->groupBy('expenditures.warehouse_id')
            ->get();

        //dd($stok_model);

        foreach ($stok_model as $data_stok){
            $pengeluaran_model = pengeluaran::where('warehouse_id', $data_stok->warehouse_id)->where('user_id', Session::get('user_id'))->whereYear('out_date',$tahun_anggaran_aktiv->years)->get();
            $stok = $data_stok->stock;
            foreach ($pengeluaran_model as $data){
                $row = array();

                if(!empty($stok)){
                    if($stok < 0){
                        $harga = $data->get_recept->unitPrice;
                    }else{
                        $harga = $data_stok->harga_satuan_stok;
                    }
                }else{
                    $harga = $data->get_recept->unitPrice;
                }

                $row[] = '<th class="no">0</th>';
                $row[] =  '<th class="dateOut"><span style="display: none">'.date('Y-m-d', strtotime($data->get_recept->dateOfpurchase))."</span> <span>".date('d-m-Y', strtotime($data->get_recept->dateOfpurchase))."</span></th>";
                $row[] = $data->get_recept->getSupplier->suppliers;
                $row[] = '';
                $row[] = '00-00-0000';
                $row[] = '';
                $row[] = '';
                $row[] = number_format($data->exit_item,2,'.','.');
                $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->unit.', '.$data->get_warehouse->specs;
                $row[] = number_format($harga,2,'.','.');
                $row[] = "";
                $row[] = '00-00-0000';
                $row[] = '';
                $row[] = '<th class="no1">0</th>';
                $row[] = date('d-m-Y', strtotime($data->out_date));
                $row[] = '';
                $row[] = '';
                $row[] = $data->get_sector->sector_name;
                $row[] = number_format($data->exit_item,2,'.','.');
                $row[] =$data->get_warehouse->goods_name.', '.$data->get_warehouse->unit.', '.$data->get_warehouse->specs;
                $row[] = number_format($harga,2,'.','.');
                $row[] = number_format($harga*$data->exit_item,2,'.','.');
                $row[] =  date('d-m-Y', strtotime($data->out_date));
                $row[] = '';
                $stok = $stok-$data->exit_item;
                $container[] = $row;
            }
        }
        $output=  array('data'=> $container);
        return response()->json($output);
    }

    public function set_data_semester(Request $req){
        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'sms' => 'required',
            'ext' => 'required'
        ]);
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));
        $ext = $req->ext;
        $sms = $req->sms;
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
       // $pengeluaran_model = pengeluaran::all()->where('out_date','>=', $tanggal_awal)->where('out_date','<=', $tanggal_akhir)->whereIn('user_id', Session::get('user_id'));
        $no = 1;
        $no_urut = 1;
        $no_urut2 = 1;
        $container = array();

        $stok_model = DB::table('expenditures')
            ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
            ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
            ->where('expenditures.user_id', Session::get('user_id'))
            ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
            ->groupBy('expenditures.warehouse_id')
            ->whereBetween('out_date',[$tanggal_awal,$tanggal_akhir])
            ->get();


        foreach ($stok_model as $data_stok){
            $pengeluaran_model = pengeluaran::where('warehouse_id', $data_stok->warehouse_id)->whereBetween('out_date',[$tanggal_awal,$tanggal_akhir])->where('user_id', Session::get('user_id'))->whereYear('out_date',$tahun_anggaran_aktiv->years)->get();
            $stok = $data_stok->stock;
            foreach ($pengeluaran_model as $data){
                $row = array();

                if(!empty($stok)){
                    if($stok < 0){
                        $harga = $data->get_recept->unitPrice;
                    }else{
                        $harga = $data_stok->harga_satuan_stok;
                    }
                }else{
                    $harga = $data->get_recept->unitPrice;
                }

                if($data->get_recept->dateOfpurchase >= $tanggal_awal && $data->get_recept->dateOfpurchase <= $tanggal_akhir) {
                    $row[] = "";
                    $row[] = date('d-m-Y', strtotime($data->get_recept->dateOfpurchase));
                    $row[] = $data->get_recept->getSupplier->suppliers;
                    $row[] = '';
                    $row[] = '00-00-0000';
                    $row[] = '';
                    $row[] = '';
                    $row[] = number_format($data->exit_item, 2, '.', '.');
                    $row[] = $data->get_warehouse->goods_name . ', ' . $data->get_warehouse->unit . ', ' . $data->get_warehouse->specs;
                    $row[] = number_format($harga, 2, '.', '.');
                    $row[] = "";
                    $row[] = '00-00-0000';
                    $row[] = '';
                    $row[] = "";
                    $row[] = date('d-m-Y', strtotime($data->out_date));
                    $row[] = '';
                    $row[] = '';
                    $row[] = $data->get_sector->sector_name;
                    $row[] = number_format($data->exit_item, 2, '.', '.');
                    $row[] = $data->get_warehouse->goods_name . ', ' . $data->get_warehouse->unit . ', ' . $data->get_warehouse->specs;
                    $row[] = number_format($harga, 2, '.', '.');
                    $row[] = number_format($harga * $data->exit_item, 2, '.', '.');
                    $row[] = date('d-m-Y', strtotime($data->out_date));
                    $row[] = '';
                    $container[] = $row;
                }
                $stok = $stok-$data->exit_item;

            }
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        if($sms=="1"){
            $lbl_sms ="I";
        }elseif ($sms== "2"){
            $lbl_sms ="II";
        }else{
            $lbl_sms ="";
        }

        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date,'tahun_anggaran'=>$tahun_anggaran_aktiv->years,'sms'=> $lbl_sms);
        if($ext==1){
            return view('content2.report.report_semester', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }


    public function get_data(){

        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $no = 1;
        $no_urut = 1;
        $container = array();

        $stok = 0;
        $harga_lama = 0;

        $stok_model = DB::table('expenditures')
            ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
            ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
            ->where('expenditures.user_id', Session::get('user_id'))
            ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
            ->groupBy('expenditures.warehouse_id')
            ->get();



        foreach ($stok_model as $data_stok_gudang){
        $pengeluaran_model = pengeluaran::where('warehouse_id', $data_stok_gudang->warehouse_id)->where('user_id', Session::get('user_id'))->whereYear('out_date',$tahun_anggaran_aktiv->years)->orderBy('out_date','ASC')->get();
            $stok_gudang =  $data_stok_gudang->stock;
            foreach ($pengeluaran_model as $data){
                $harga_penerimaan = $data->get_recept->unitPrice;

                if($stok_gudang <= 0){
                    $harga_lama = $harga_penerimaan;
                }else{
                    $harga_lama = $data_stok_gudang->harga_satuan_stok;
                }

                $row = array();
                $row[] = '<th class="no">0</th>';
                $row[] = '<th class="dateOut"><span style="display: none">'.date('Y-m-d',strtotime($data->out_date))."</span> <span>".date('d-m-Y',strtotime($data->out_date))."</span></th>";
                $row[] = '<th id="joker">'.$no_urut++.'</th>';
                $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->specs;
                $row[] = number_format($data->exit_item,2,',','.');
                $row[] = number_format($harga_lama,2,',','.');
                $row[] = number_format($data->exit_item*$harga_lama,2,',','.');
                $row[] = $data->get_sector->sector_name;
                $row[] = date('d-m-Y',strtotime($data->out_date));
                $row[] = $data->information;
                $kurangi_stok = $stok_gudang - $data->exit_item;
                $stok_gudang = $kurangi_stok;
                $container[] = $row;
            }
        }
        $output=  array('data'=> $container);
        return response()->json($output);
    }

    public function set_data(Request $req){

        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'ext' => 'required'
        ]);
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $tanggal_print = date('Y-m-d', strtotime($req->print_date));
        $ext = $req->ext;
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
        $id_barang = $req->warehouse_id1;

        $stok = 0;
        $harga_lama = 0;
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $no = 1;
        $no_urut = 1;
        $container = array();

        if($id_barang == 0){
            $stok_model = DB::table('expenditures')
                ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
                ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
                ->where('expenditures.user_id', Session::get('user_id'))
                ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
                ->where('out_date','>=', $tanggal_awal)
                ->where('out_date','<=', $tanggal_akhir)
                ->groupBy('expenditures.warehouse_id')
                ->get();
        }else{
            $stok_model = DB::table('expenditures')
                ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
                ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
                ->where('expenditures.user_id', Session::get('user_id'))
                ->where('expenditures.warehouse_id',$id_barang)
                ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
                ->where('out_date','>=', $tanggal_awal)
                ->where('out_date','<=', $tanggal_akhir)
                ->groupBy('expenditures.warehouse_id')
                ->get();
        }
     //   dd($stok_model);
        foreach ($stok_model as $data_stok_gudang){
            $pengeluaran_model = pengeluaran::all()->where('warehouse_id',$data_stok_gudang->warehouse_id)->where('out_date','>=', $tanggal_awal)->where('out_date','<=', $tanggal_akhir)->sortBy('out_date')->where('user_id', Session::get('user_id'));
            $stok_gudang =  $data_stok_gudang->stock;
            foreach ($pengeluaran_model as $data){
                $row = array();
                $harga_penerimaan = $data->get_recept->unitPrice;
                if($stok_gudang <= 0){
                    $harga_lama = $harga_penerimaan;
                }else{
                    $harga_lama = $data_stok_gudang->harga_satuan_stok;
                }

                $row[] = '<th class="no">0</th>';
                $row[] = date('d-m-Y',strtotime($data->out_date));
                $row[] = '<th id="joker">'.$no_urut++.'</th>';
                $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->specs;
                $row[] = number_format($data->exit_item,2,',','.');
                $row[] = number_format($harga_lama,2,',','.');
                $row[] = number_format($data->exit_item*$harga_lama,2,',','.');
                $row[] = $data->get_sector->sector_name;
                $row[] = date('d-m-Y',strtotime($data->out_date));
                $row[] = $data->information;
                $kurangi_stok = $stok_gudang - $data->exit_item;
                $stok_gudang = $kurangi_stok;
                $container[] = $row;
            }
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$tanggal_print);
        if($ext==1){
            return view('content2.page_expedures.report_receipt', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function set_data_bpk(Request $req){
        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'ext' => 'required'
        ]);
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $tanggal_print = date('Y-m-d', strtotime($req->print_date));
        $ext = $req->ext;
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
        $stok = 0;
        $harga_lama = 0;
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $no = 1;
        $no_urut = 1;
        $container = array();
        $id_barang = $req->warehouse_id1;
        if($id_barang == 0){
            $stok_model = DB::table('expenditures')
                ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
                ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
                ->where('expenditures.user_id', Session::get('user_id'))
                ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
                ->groupBy('expenditures.warehouse_id')
                ->get();
        }else{
            $stok_model = DB::table('expenditures')
                ->leftJoin('stock_goods','expenditures.warehouse_id','=','stock_goods.warehouse_id')
                ->select('expenditures.warehouse_id','stock_goods.stock','stock_goods.harga_satuan_stok')
                ->where('expenditures.user_id', Session::get('user_id'))
                ->where('expenditures.warehouse_id',$id_barang)
                ->whereYear('expenditures.out_date',$tahun_anggaran_aktiv->years)
                ->groupBy('expenditures.warehouse_id')
                ->get();
        }
        foreach ($stok_model as $data_stok_gudang){
            $pengeluaran_model = pengeluaran::all()->where('warehouse_id',$data_stok_gudang->warehouse_id)->where('out_date','>=', $tanggal_awal)->where('out_date','<=', $tanggal_akhir)->sortBy('out_date')->whereIn('user_id', Session::get('user_id'));
            $stok_gudang =  $data_stok_gudang->stock;
            foreach ($pengeluaran_model as $data){
                $row = array();
                $harga_penerimaan = $data->get_recept->unitPrice;
                if($stok_gudang <= 0){
                    $harga_lama = $harga_penerimaan;
                }else{
                    $harga_lama = $data_stok_gudang->harga_satuan_stok;
                }

                $row[] = '<th class="no">0</th>';
                $row[] = date('d-m-Y',strtotime($data->out_date));
                $row[] = '<th id="joker">'.$no_urut++.'</th>';
                $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->specs;
                $row[] = number_format($data->exit_item,2,',','.');
                $row[] = number_format($harga_lama,2,',','.');
                $row[] = number_format($data->exit_item*$harga_lama,2,',','.');
                $row[] = $data->get_sector->sector_name;
                $row[] = date('d-m-Y',strtotime($data->out_date));
                $row[] = $data->information;
                $kurangi_stok = $stok_gudang - $data->exit_item;
                $stok_gudang = $kurangi_stok;
                $container[] = $row;
            }
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$tanggal_print);

        if($ext==1){
            return view('content2.page_expedures.report_receipt', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function get_data_bph(){

        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $pengeluaran_model = pengeluaran::where('user_id', Session::get('user_id'))->whereYear('out_date',$tahun_anggaran_aktiv->years)->orderBy('out_date','asc')->get();
        $no = 1;
        $no_urut = 1;
        $container = array();

        foreach ($pengeluaran_model as $data){
            $row = array();
            $harga_penerimaan = $data->get_recept->amountOfgoods;
            $row[] = $no++;
            $row[] = date('d-m-Y', strtotime($data->get_recept->dateOfpurchase));
            $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->specs;
            $row[] = '';
            $row[] = '----';
            $row[] = number_format($data->exit_item,2,'.','.');
            $row[] = '';
            $row[] = '00-00-0000';
            $row[] = '';
            $row[] = date('d-m-Y', strtotime($data->out_date));
            $row[] = $data->get_sector->sector_name;
            $row[] = number_format($data->exit_item,2,'.','.');
            $row[] = date('d-m-Y', strtotime($data->out_date));
            $row[] = '';

            $container[] = $row;
        }
        $output=  array('data'=> $container);
        return response()->json($output);
    }

    public function set_data_bph(Request $req){
        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'ext' => 'required'
        ]);
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));
        $ext = $req->ext;
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $pengeluaran_model = pengeluaran::where('out_date','>=', $tanggal_awal)->where('out_date','<=', $tanggal_akhir)->where('user_id', Session::get('user_id'))->orderBy('out_date','asc')->get();
        $no = 1;
        $no_urut = 1;
        $container = array();


        foreach ($pengeluaran_model as $data){
            $row = array();
            $harga_penerimaan = $data->get_recept->amountOfgoods;
            $row[] = $no++;
            $row[] = date('d-m-Y', strtotime($data->get_recept->dateOfpurchase));
            $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->specs;
            $row[] = '';
            $row[] = '----';
            $row[] = number_format($data->exit_item,2,'.','.');
            $row[] = '';
            $row[] = '00-00-0000';
            $row[] = '';
            $row[] = date('d-m-Y', strtotime($data->out_date));
            $row[] = $data->get_sector->sector_name;
            $row[] = number_format($data->exit_item,2,'.','.');
            $row[] = date('d-m-Y', strtotime($data->out_date));
            $row[] = '';

            $container[] = $row;
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();


        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date);
        if($ext==1){
            return view('content2.report.report_bhp', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function set_data_bph_bpk(Request $req){
        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'ext' => 'required'
        ]);
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));
        $ext = $req->ext;
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $pengeluaran_model = pengeluaran::all()->where('out_date','>=', $tanggal_awal)->where('out_date','<=', $tanggal_akhir)->whereIn('user_id', Session::get('user_id'));
        $no = 1;
        $no_urut = 1;
        $container = array();


        foreach ($pengeluaran_model as $data){
            $row = array();
            $harga_penerimaan = $data->get_recept->amountOfgoods;
            $row[] = $no++;
            $row[] = date('d-m-Y', strtotime($data->get_recept->dateOfpurchase));
            $row[] = $data->get_warehouse->goods_name.', '.$data->get_warehouse->specs;
            $row[] = '';
            $row[] = '----';
            $row[] = number_format($data->exit_item,2,'.','.');
            $row[] = '';
            $row[] = '00-00-0000';
            $row[] = '';
            $row[] = date('d-m-Y', strtotime($data->out_date));
            $row[] = $data->get_sector->sector_name;
            $row[] = number_format($data->exit_item,2,'.','.');
            $row[] = date('d-m-Y', strtotime($data->out_date));
            $row[] = '';

            $container[] = $row;
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();


        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date);
        if($ext==1){
            return view('content2.report.report_bhp', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }
}
