<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Session;

use Validate;

use App\Mutasi as mutasi;

use App\Warehouse as gudang;

use App\Expenditures as pengeluaran;

use App\Goodreceipt as penerimaan;

use App\Instance as instansi;

use App\Province as provinsi;

use App\Fiscal_years as Tahun_anggaran;

use App\Authorized as berwanang;

use App\StockGoods as stok_lalu;

use App\typeOfGoods as jenis_barang;


use Redirect;


class MutasiController extends Controller
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



    public function laporan_kb_content()
    {
        $pass = array('gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')));
        return view('content2.report.report_kb_content', $pass);
    }

    public function laporan_kb_content_bpk()
    {
        $pass = array('gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')));
        return view('content_pbpk.report.report_kb_content', $pass);
    }

    public function laporan_kb_content_pemprov()
    {
        $pass = array('gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')));
        return view('content_pInspektorat.report.report_kb_content', $pass);
    }

    public function laporan_kb_content_pemkot()
    {
        $pass = array('gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')));
        return view('content_pInspektorat_pemkot.report.report_kb_content', $pass);
    }

    public function laporan_kb_content_pemkab()
    {
        $pass = array('gudang'=> gudang::all()->whereIn('user_id', Session::get('user_id')));
        return view('content_pInspektorat_pemkab.report.report_kb_content', $pass);
    }

    public function laporan_mutasi_content()
    {
        $data_barang = gudang::where('user_id', Session::get('user_id'))->get();
        $data_jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        return view('content2.report.report_mutasi_content', array('gudang' => $data_barang,'jenis_barang'=>$data_jenis_barang));
    }

    public function laporan_bpk_mutasi_content()
    {
        $data_barang = gudang::where('user_id', Session::get('user_id'))->get();
        $data_jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        return view('content_pbpk.report.report_mutasi_content',array('gudang' => $data_barang,'jenis_barang'=>$data_jenis_barang));
    }

    public function laporan_pemprov_mutasi_content()
    {
        $data_barang = gudang::where('user_id', Session::get('user_id'))->get();
        $data_jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        return view('content_pInspektorat.report.report_mutasi_content', array('gudang' => $data_barang,'jenis_barang'=>$data_jenis_barang));
    }

    public function laporan_pemkot_mutasi_content()
    {
        $data_barang = gudang::where('user_id', Session::get('user_id'))->get();
        $data_jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        return view('content_pInspektorat_pemkot.report.report_mutasi_content', array('gudang' => $data_barang,'jenis_barang'=>$data_jenis_barang));
    }

    public function laporan_pemkab_mutasi_content()
    {
        $data_barang = gudang::where('user_id', Session::get('user_id'))->get();
        $data_jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        return view('content_pInspektorat_pemkab.report.report_mutasi_content', array('gudang' => $data_barang,'jenis_barang'=>$data_jenis_barang));
    }

    public function singron_mutasi()
    {
            $master_id = Session::get('user_id');

            $data_penerimaan = DB::table('goodreceipt')->select('id','dateOfpurchase','warehouse_id','unitPrice','amountOfgoods','totalPrice')->whereNotIn('id', function ($query){
                $query->select('goodreceipt_id')->from('mutasi');
            })->where('user_id',$master_id)->orderBy('dateOfpurchase', 'asc')->get();

            if(count($data_penerimaan) !=0)
            {
                foreach ($data_penerimaan as $key) {
                    $jumlah_barang = gudang::find($key->warehouse_id);
                    $stok_akhir = $key->amountOfgoods+$jumlah_barang->initial_stock;
                    $total_awal_penerimaan = $key->totalPrice;

                    $tambah_mutasi = new mutasi([
                        'tgl_transaksi'  => $key->dateOfpurchase,
                        'warehouse_id'   => $key->warehouse_id,
                        'goodreceipt_id' => $key->id,
                        'expenditures_id'=> 0,
                        'last_stock' => $jumlah_barang->initial_stock,
                        'jum_in' => $key->amountOfgoods,
                        'jum_out' => 0,
                        'remaining_stok'=> $stok_akhir,
                        'total_start' => $jumlah_barang->total_price,
                        'total_final' => $total_awal_penerimaan,
                        'total' => $total_awal_penerimaan,
                        'user_id' => $master_id
                    ]);

                    if($tambah_mutasi->save()){
                        $jumlah_barang->initial_stock=$stok_akhir;
                        $jumlah_barang->total_price=$total_awal_penerimaan;
                        $jumlah_barang->save();

                        $data_pengeluaran = DB::table('expenditures')->select('*','expenditures.id as id_pengeluaran')->join('goodreceipt','goodreceipt.id','=','expenditures.goodreceipt_id')->whereNotIn('expenditures.id', function ($query){
                            $query->select('expenditures_id')->from('mutasi');
                        })->where('expenditures.user_id',$master_id)->orderBy('out_date', 'asc')->get();

                        foreach ($data_pengeluaran as $index => $value) {
                            $jumlah_barang_pengeluaran = gudang::find($value->warehouse_id);
                            $stok_akhir_pengeluaran = $jumlah_barang_pengeluaran->initial_stock-$value->exit_item;
                            $total_awal_pengeluaran =  $jumlah_barang_pengeluaran->total_price-($value->exit_item*$key->unitPrice);

                            $tambah_mutasi = new mutasi([
                                'tgl_transaksi'  => $value->out_date,
                                'warehouse_id'   => $value->warehouse_id,
                                'goodreceipt_id' => 0,
                                'expenditures_id'=> $value->id_pengeluaran,
                                'last_stock' => $jumlah_barang_pengeluaran->initial_stock,
                                'jum_in' => 0,
                                'jum_out' => $value->exit_item,
                                'remaining_stok'=> $stok_akhir_pengeluaran,
                                'total_start' => $jumlah_barang->total_price,
                                'total_final' => $total_awal_pengeluaran,
                                'total' => $total_awal_pengeluaran,
                                'user_id' => $master_id
                            ]);
                            if($tambah_mutasi->save()){
                                $jumlah_barang_pengeluaran->initial_stock = $stok_akhir_pengeluaran;
                                $jumlah_barang_pengeluaran->total_price = $total_awal_pengeluaran;
                                $jumlah_barang_pengeluaran->save();
                            }
                        }

                        $respon=[
                            'status'=> true,
                            'info' => 'Mutati sedang di proses'
                        ];
                        return response()->json($respon);
                    }
                }
                $respon=[
                    'status'=> true,
                    'info' => 'Mutati sedang di proses'
                ];
                return response()->json($respon);
            }else{
                $data_pengeluaran = DB::table('expenditures')->select('*')->whereNotIn('id', function ($query){
                    $query->select('expenditures_id')->from('mutasi');
                })->where('user_id',$master_id)->orderBy('out_date', 'asc')->get();;

                 foreach ($data_pengeluaran as $value){
                     $jumlah_barang_pengeluaran = gudang::find($value->warehouse_id);
                     $penerimaan = penerimaan::find($value->goodreceipt_id);
                     $stok_akhir = $jumlah_barang_pengeluaran->initial_stock-$value->exit_item;
                     $harga_total_stok =  $jumlah_barang_pengeluaran->total_price-($value->exit_item*$penerimaan->unitPrice);

                     $tambah_mutasi = new mutasi([
                         'tgl_transaksi'  => $value->out_date,
                         'warehouse_id'   => $value->warehouse_id,
                         'goodreceipt_id' => 0,
                         'expenditures_id'=> $value->id,
                         'last_stock' => $jumlah_barang_pengeluaran->initial_stock,
                         'jum_in' => 0,
                         'jum_out' => $value->exit_item,
                         'remaining_stok'=> $stok_akhir,
                         'total_start' => $jumlah_barang_pengeluaran->total_price,
                         'total_final' => $harga_total_stok,
                         'total' => $harga_total_stok,
                         'user_id' => $master_id
                     ]);
                     if($tambah_mutasi->save()){
                         $jumlah_barang_pengeluaran->initial_stock = $stok_akhir;
                         $jumlah_barang_pengeluaran->total_price = $harga_total_stok;
                         $jumlah_barang_pengeluaran->save();
                     }
                 }
                $respon=[
                    'status'=> true,
                    'info' => 'Mutati sedang di proses'
                ];
                return response()->json($respon);
            }

        $respon=[
            'status'=> true,
            'info' => 'Data Sudah Di mutasi'
        ];
        return response()->json($respon);
    }

    public function get_kb(Request $req){
        $this->validate($req,[
            'id_barang'=> 'required'
        ]);

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $id_barang = $req->id_barang;

        $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
            ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
            ->leftjoin('stock_goods','stock_goods.warehouse_id','=','warehouse.id')
            ->select('warehouse.id','warehouse.initial_stock','warehouse.goods_name','warehouse.unit',DB::raw('if(stock_goods.stock is null,0,stock_goods.stock) as stock'))
            ->groupBy('warehouse.id')
            ->where('warehouse.id', $id_barang)
            ->where('mutasi.user_id', Session::get('user_id'))
            ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
            ->get();


        $no=1;
        $container = array();
        $sisa_barang=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
          //  $mutasi_modal = DB::table('mutasi')->where('warehouse_id',$barang_gudang->id)->orderBy('tgl_transaksi','asc')->orderBy('warehouse_id','asc')->select('*')->get();
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('user_id', Session::get('user_id'))->where('fiscal_years_id',$tahun_anggaran->id)->first();
            if(!empty($ambil_stokbarang_lalu->stock)){
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
            }else{
                $sisa_stok_kemarin = 0;
            }

            $mutasi_modal = DB::table('mutasi')
                ->leftJoin('expenditures','expenditures.id','=', 'mutasi.expenditures_id')
                ->leftJoin('goodreceipt','mutasi.goodreceipt_id','=','goodreceipt.id')
                ->select('mutasi.*', DB::raw("concat_ws('',goodreceipt.id, expenditures.goodreceipt_id) as kumpulan_id"))
                ->where('mutasi.user_id', Session::get('user_id'))
                ->where('mutasi.warehouse_id', $barang_gudang->id)
                ->whereYear('tgl_transaksi', $tahun_anggaran->years)
                ->orderBy('tgl_transaksi', 'asc')
                ->orderBy('kumpulan_id', 'asc')
                ->orderBy('id', 'asc')->get();

            foreach ($mutasi_modal as $key =>$data) {
                $row = array();

                if($data->goodreceipt_id !=0){
                    $sisa_barang = $sisa_stok_kemarin+$data->jum_in;
                 }

                if($data->expenditures_id !=0){
                    $pengeluaran_model = pengeluaran::find($data->expenditures_id);
                    if($key==0){
                        $sisa_barang = $sisa_stok_kemarin+$sisa_barang-$data->jum_out;
                        $total_penerimaan = $sisa_stok_kemarin;
                    }else{
                        $sisa_barang = $sisa_stok_kemarin - $data->jum_out;
                    }
                }

                $row[] = $no++;
                $row[] = date('d-m-Y', strtotime($data->tgl_transaksi));

                if($data->jum_in)

                //penerimaan

                $row[] = number_format($sisa_stok_kemarin+$data->jum_in,2,'.','.');
                //pengeluaran
                $row[] = number_format($data->jum_out,2,'.','.');
                //sisa
                $row[] = number_format($sisa_barang,2,'.','.');

                $sisa_stok_kemarin = $sisa_barang;

                $container[]= $row;
            }
        }


        $output = array('data'=> $container);

        return response()->json($output );
    }

    public function get_bpk_kb(Request $req){
        $this->validate($req,[
            'id_barang'=> 'required'
        ]);

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $id_barang = $req->id_barang;

        $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
            ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
            ->leftjoin('stock_goods','stock_goods.warehouse_id','=','warehouse.id')
            ->select('warehouse.id','warehouse.initial_stock','warehouse.goods_name','warehouse.unit',DB::raw('if(stock_goods.stock is null,0,stock_goods.stock) as stock'))
            ->groupBy('warehouse.id')
            ->where('warehouse.id', $id_barang)
            ->where('mutasi.user_id', Session::get('user_id'))
            ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
            ->get();


        $no=1;
        $container = array();
        $sisa_barang=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
            //  $mutasi_modal = DB::table('mutasi')->where('warehouse_id',$barang_gudang->id)->orderBy('tgl_transaksi','asc')->orderBy('warehouse_id','asc')->select('*')->get();
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('user_id', Session::get('user_id'))->where('fiscal_years_id',$tahun_anggaran->id)->first();
            if(!empty($ambil_stokbarang_lalu->stock)){
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
            }else{
                $sisa_stok_kemarin = 0;
            }
            $mutasi_modal = DB::table('mutasi')->where('warehouse_id',$barang_gudang->id)->whereYear('tgl_transaksi',$tahun_anggaran->years)->where('user_id', Session::get('user_id'))->orderBy('tgl_transaksi','asc')->select('*')->get();

            foreach ($mutasi_modal as $key =>$data) {
                $row = array();

                if($data->goodreceipt_id !=0){
                    $sisa_barang = $sisa_stok_kemarin+$data->jum_in;
                }

                if($data->expenditures_id !=0){
                    $pengeluaran_model = pengeluaran::find($data->expenditures_id);
                    if($key==0){
                        $sisa_barang = $sisa_stok_kemarin+$sisa_barang-$data->jum_out;
                    }else{
                        $sisa_barang = $sisa_stok_kemarin - $data->jum_out;
                    }
                }

                $row[] = $no++;
                $row[] = date('d-m-Y', strtotime($data->tgl_transaksi));

                if($data->jum_in)

                    //penerimaan
                    $row[] = number_format($sisa_stok_kemarin+$data->jum_in,2,'.','.');
                //pengeluaran
                $row[] = number_format($data->jum_out,2,'.','.');
                //sisa
                $row[] = number_format($sisa_barang,2,'.','.');

                $sisa_stok_kemarin = $sisa_barang;

                $container[]= $row;
            }
        }


        $output = array('data'=> $container);

        return response()->json($output );
    }

    public function set_kb(Request $req){
        $this->validate($req,[
            'id_barang'=> 'required',
            'first_date' => 'required',
            'last_date' =>'required',
            'print_date'=> 'required'
        ]);

        $id_barang = $req->id_barang;
        $ext = $req->ext;
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));
        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();


        $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
            ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
            ->leftjoin('stock_goods','stock_goods.warehouse_id','=','warehouse.id')
            ->select('warehouse.id','warehouse.initial_stock','warehouse.goods_name','warehouse.unit',DB::raw('if(stock_goods.stock is null,0,stock_goods.stock) as stock'))
            ->groupBy('warehouse.id')
            ->where('warehouse.id', $id_barang)
            ->where('mutasi.user_id', Session::get('user_id'))
            //->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
            ->get();

        $no=1;
        $container = array();
        $sisa_barang=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
            //  $mutasi_modal = DB::table('mutasi')->where('warehouse_id',$barang_gudang->id)->orderBy('tgl_transaksi','asc')->orderBy('warehouse_id','asc')->select('*')->get();
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('fiscal_years_id',$tahun_anggaran->id)->first();
            if(!empty($ambil_stokbarang_lalu->stock)){
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
            }else{
                $sisa_stok_kemarin = 0;
            }

            $mutasi_modal = DB::table('mutasi')
                ->leftJoin('expenditures','expenditures.id','=', 'mutasi.expenditures_id')
                ->leftJoin('goodreceipt','mutasi.goodreceipt_id','=','goodreceipt.id')
                ->select('mutasi.*', DB::raw("concat_ws('',goodreceipt.id, expenditures.goodreceipt_id) as kumpulan_id"))
                ->where('mutasi.user_id', Session::get('user_id'))
                ->where('mutasi.warehouse_id', $barang_gudang->id)
                ->whereYear('tgl_transaksi', $tahun_anggaran->years)
                ->orderBy('tgl_transaksi', 'asc')
                ->orderBy('kumpulan_id', 'asc')
                ->orderBy('id', 'asc')->get();

            foreach ($mutasi_modal as $key =>$data) {
                $row = array();

                if($data->goodreceipt_id !=0){
                    $sisa_barang = $sisa_stok_kemarin+$data->jum_in;
                }

                if($data->expenditures_id !=0){
                    $pengeluaran_model = pengeluaran::find($data->expenditures_id);
                    if($key==0){
                        $sisa_barang = $sisa_stok_kemarin+$sisa_barang-$data->jum_out;
                    }else{
                        $sisa_barang = $sisa_stok_kemarin - $data->jum_out;
                    }
                }
                if($data->tgl_transaksi >= $tanggal_awal && $data->tgl_transaksi <= $tanggal_akhir) {

                    $row[] = $no++;
                    $row[] = date('d-m-Y', strtotime($data->tgl_transaksi));

                    //if($data->jum_in)

                    //penerimaan
                    $row[] = number_format($sisa_stok_kemarin+$data->jum_in, 2, '.', '.');
                    //pengeluaran
                    $row[] = number_format($data->jum_out, 2, '.', '.');
                    //sisa
                    $row[] = number_format($sisa_barang, 2, '.', '.');

                    $sisa_stok_kemarin = $sisa_barang;

                    $container[] = $row;
                }
            }
        }

        $gudang = gudang::find($id_barang);
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'barang'=> $gudang ,'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date);
        if($ext==1){
            return view('content2.report.report_kb', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function set_bpk_kb(Request $req){
        $this->validate($req,[
            'id_barang'=> 'required',
            'first_date' => 'required',
            'last_date' =>'required',
            'print_date'=> 'required'
        ]);

        $id_barang = $req->id_barang;
        $ext = $req->ext;
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();


        $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
            ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
            ->leftjoin('stock_goods','stock_goods.warehouse_id','=','warehouse.id')
            ->select('warehouse.id','warehouse.initial_stock','warehouse.goods_name','warehouse.unit',DB::raw('if(stock_goods.stock is null,0,stock_goods.stock) as stock'))
            ->groupBy('warehouse.id')
            ->where('warehouse.id', $id_barang)
            ->where('mutasi.user_id', Session::get('user_id'))
            //->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
            ->get();

        $no=1;
        $container = array();
        $sisa_barang=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
            //  $mutasi_modal = DB::table('mutasi')->where('warehouse_id',$barang_gudang->id)->orderBy('tgl_transaksi','asc')->orderBy('warehouse_id','asc')->select('*')->get();
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('user_id', Session::get('user_id'))->where('fiscal_years_id',$tahun_anggaran->id)->first();
            if(!empty($ambil_stokbarang_lalu->stock)){
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
            }else{
                $sisa_stok_kemarin = 0;
            }
            $mutasi_modal = DB::table('mutasi')->where('warehouse_id',$barang_gudang->id)->whereYear('tgl_transaksi',$tahun_anggaran->years)->where('user_id', Session::get('user_id'))->orderBy('tgl_transaksi','asc')->select('*')->get();

            foreach ($mutasi_modal as $key =>$data) {
                $row = array();

                if($data->goodreceipt_id !=0){
                    $sisa_barang = $sisa_stok_kemarin+$data->jum_in;
                }

                if($data->expenditures_id !=0){
                    $pengeluaran_model = pengeluaran::find($data->expenditures_id);
                    if($key==0){
                        $sisa_barang = $sisa_stok_kemarin+$sisa_barang-$data->jum_out;
                    }else{
                        $sisa_barang = $sisa_stok_kemarin - $data->jum_out;
                    }
                }
                if($data->tgl_transaksi >= $tanggal_awal && $data->tgl_transaksi <= $tanggal_akhir) {

                    $row[] = $no++;
                    $row[] = date('d-m-Y', strtotime($data->tgl_transaksi));

                    //if($data->jum_in)

                    //penerimaan
                    $row[] = number_format($data->jum_in, 2, '.', '.');
                    //pengeluaran
                    $row[] = number_format($data->jum_out, 2, '.', '.');
                    //sisa
                    $row[] = number_format($sisa_barang, 2, '.', '.');

                    $sisa_stok_kemarin = $sisa_barang;

                    $container[] = $row;
                }
            }
        }

        $gudang = gudang::find($id_barang);
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $output=  array('data'=> $container,'instansi'=> $instansi, 'zona'=> $wilaya, 'barang'=> $gudang ,'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date);
        if($ext==1){
            return view('content_pbpk.report.report_kb', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }
//============================================ Mutasi Lama  ============================================================

    public function remake_get_mutasi(){

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();


        $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
            ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
            ->select('warehouse.id','warehouse.initial_stock','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit','warehouse.typeofgoods_id')
            ->where('warehouse.user_id',Session::get('user_id'))
            ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
            //->orderBy('mutasi.tgl_transaksi', 'asc')
            ->groupBy('warehouse.id')
            ->get();

        $container = array();
        $harga_penerimaan=0;
        $total_harga_penerimaan=0;
        $total_harga_pengeluaran=0;
        $harga_pengeluaran=0;
        $harga_stok=0;
        $stok_gudang=0;
        $stok_penerimaan=0;
        $stok_pengeluaran =0;
        $sisa_barang=0;
        $total_jumlah_pengeluaran=0;

        $sisa_stok=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('user_id', Session::get('user_id'))->where('fiscal_years_id', $tahun_anggaran->id)->first();

            $mutasi_modal = DB::table('mutasi')
                ->leftJoin('expenditures','expenditures.id','=', 'mutasi.expenditures_id')
                ->leftJoin('goodreceipt','mutasi.goodreceipt_id','=','goodreceipt.id')
                ->select('mutasi.*', DB::raw("concat_ws('',goodreceipt.id, expenditures.goodreceipt_id) as kumpulan_id"))
                ->where('mutasi.user_id', Session::get('user_id'))
                ->where('mutasi.warehouse_id', $barang_gudang->id)
                ->whereYear('tgl_transaksi', $tahun_anggaran->years)
                ->orderBy('tgl_transaksi', 'asc')
                ->orderBy('kumpulan_id', 'asc')
                ->orderBy('id', 'asc')->get();


            if (!empty($ambil_stokbarang_lalu->stock)) {
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
                $harga_stok_kemarin = $ambil_stokbarang_lalu->harga_satuan_stok;
            } else {
                $sisa_stok_kemarin = 0;
                $harga_stok_kemarin = 0;
            }

            foreach ($mutasi_modal as $key => $data) {
                $row = array();

                if($key==0 && $data->goodreceipt_id !=0)
                {
                    $stok_gudang = $sisa_stok_kemarin;
                    $harga_stok = $stok_gudang*$harga_stok_kemarin;
                    $penerimaan_barang = penerimaan::find($data->goodreceipt_id);
                    $stok_penerimaan = $data->jum_in;
                    $harga_penerimaan = $penerimaan_barang->unitPrice;
                    $harga_pengeluaran=0;
                    $stok_pengeluaran =0;
                    $total_harga_pengeluaran=0;
                    $total_harga_penerimaan = $harga_penerimaan* $penerimaan_barang->amountOfgoods;
                    $sisa_barang = $stok_gudang+$penerimaan_barang->amountOfgoods;
                    $total_jumlah_pengeluaran = $harga_stok+$total_harga_penerimaan;
                }else if($data->goodreceipt_id !=0){
                    $stok_pengeluaran =0;
                    $harga_pengeluaran=0;
                    $total_harga_pengeluaran=0;

                    $penerimaan_barang = penerimaan::find($data->goodreceipt_id);
                    $stok_penerimaan=$data->jum_in;
                    $harga_penerimaan = $penerimaan_barang->unitPrice;
                    $total_harga_penerimaan = $harga_penerimaan* $penerimaan_barang->amountOfgoods;
                    $sisa_barang += $stok_penerimaan;
                    $total_jumlah_pengeluaran +=$total_harga_penerimaan;
                }

                if($key==0 && $data->expenditures_id !=0)
                {
                    $sisa_stok = $sisa_stok_kemarin;
                    $stok_gudang = $sisa_stok_kemarin;
                    $harga_stok = $stok_gudang*$harga_stok_kemarin;
                    $stok_pengeluaran = $data->jum_out;

                    $data_pengeluaran=pengeluaran::find($data->expenditures_id);
                    $penerimaan_barang = penerimaan::find($data_pengeluaran->goodreceipt_id);

                    if($sisa_stok <= 0){
                        $harga_pengeluaran = $penerimaan_barang->unitPrice;
                    }else if($sisa_stok > 0){
                        $harga_pengeluaran = $ambil_stokbarang_lalu->harga_satuan_stok;
                    }

                    $total_harga_pengeluaran = $stok_pengeluaran * $harga_pengeluaran;
                    $sisa_barang = $sisa_stok-$stok_pengeluaran;
                    $total_jumlah_pengeluaran = $harga_stok-$total_harga_pengeluaran;

                }else if($data->expenditures_id !=0){
                    $stok_pengeluaran = $data->jum_out;
                    $sisa_stok -=$stok_pengeluaran;
                    $sisa_stok_kemarin-=$stok_pengeluaran;

                    $stok_penerimaan = 0;
                    $harga_penerimaan = 0;
                    $total_harga_penerimaan = 0;

                    $data_pengeluaran=pengeluaran::find($data->expenditures_id);
                    $penerimaan_barang = penerimaan::find($data_pengeluaran->goodreceipt_id);

                    if($sisa_stok < 0){
                        $harga_pengeluaran = $penerimaan_barang->unitPrice;
                    }else if($sisa_stok > 0){
                        $harga_pengeluaran =$harga_stok_kemarin;
                    }

                    $total_harga_pengeluaran = $stok_pengeluaran * $harga_pengeluaran;
                    $sisa_barang -= $stok_pengeluaran;
                    $total_jumlah_pengeluaran -=$total_harga_pengeluaran;

                    if(sprintf("%.3f", $sisa_barang)=="-0.00"){
                        $sisa_barang =0;
                    }
                    //$total_jumlah_pengeluaran -=$total_harga_pengeluaran;

                    if(sprintf("%.3f", $total_jumlah_pengeluaran)=="-0.00"){
                        $total_jumlah_pengeluaran =0;
                    }
                }

                $jenis_barang = jenis_barang::find($barang_gudang->typeofgoods_id);

                if($jenis_barang->formula==1){
                    $harga_stok = round($harga_stok, -3);
                    $harga_penerimaan = round($harga_penerimaan, -3);
                    $total_harga_penerimaan = round($total_harga_penerimaan, -3);
                    $harga_pengeluaran = round($harga_pengeluaran, -3);
                    $total_harga_pengeluaran = round($total_harga_pengeluaran, -3);
                    $total_jumlah_pengeluaran = round($total_jumlah_pengeluaran, -3);
                }

                $row[] = '<th class="no">0</th>';
                $row[] = '<th class="dateOut"><span style="display: none">' . date('Y-m-d', strtotime($data->tgl_transaksi)) . "</span> <span>" . date('d-m-Y', strtotime($data->tgl_transaksi)) . "</span></th>";
                $row[] = $barang_gudang->goods_name . ',' .  $barang_gudang->specs. ', ' . $barang_gudang->brand;
                //======================== Barang ======================================
                $row[] = number_format($stok_gudang, 2, ',', '.');
                $row[] = $barang_gudang->unit;
                $row[] = number_format($harga_stok, 2, ',', '.');

                //penerimaan
                $row[] = number_format($stok_penerimaan, 2, ',', '.');
                $row[] = number_format($harga_penerimaan, 2, ',', '.');
                $row[] = number_format($total_harga_penerimaan, 2, ',', '.');
                //pengeluaran
                $row[] = number_format($stok_pengeluaran, 2, ',', '.');
                $row[] = number_format($harga_pengeluaran, 2, ',', '.');
                $row[] = number_format($total_harga_pengeluaran, 2, '.', '.');

                //sisa
                $row[] = number_format($sisa_barang, 2, ',', '.');
                $row[] = number_format($total_jumlah_pengeluaran, 2, ',', '.');
                $container[] = $row;

                $stok_gudang= $sisa_barang;
                $harga_stok = $total_jumlah_pengeluaran;
                $sisa_stok = $sisa_stok_kemarin;

            }
        }
        $output = array('data' => $container);
        return response()->json($output);
    }

    public function set_mutasi(Request $req){

//  $mutasi_modal = mutasi::all()->where('tgl_transaksi','>=', $tanggal_awal)->where('tgl_transaksi','<=', $tanggal_akhir)->where('user_id',  Session::get('user_id'));


        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'ext' => 'required'
        ]);

        $ext = $req->ext;
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();


        if($req->warehouse_id1 != 0){
            $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
                ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
                ->select('warehouse.id','warehouse.initial_stock','warehouse.typeofgoods_id','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit')
                ->where('warehouse.user_id',Session::get('user_id'))
                ->where('mutasi.warehouse_id', $req->warehouse_id1)
                ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
                ->groupBy('warehouse.id')
                ->get();
        }else if($req->jenis_barang !=0){
            $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
                ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
                ->select('warehouse.id','warehouse.initial_stock','warehouse.typeofgoods_id','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit')
                ->where('warehouse.user_id',Session::get('user_id'))
               ->where('warehouse.typeofgoods_id', $req->jenis_barang)
                ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
                ->groupBy('warehouse.id')
                ->get();
        }else{
            $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
                ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
                ->select('warehouse.id','warehouse.initial_stock','warehouse.typeofgoods_id','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit')
                ->where('warehouse.user_id',Session::get('user_id'))
                ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
                ->groupBy('warehouse.id')
                ->get();
        }


        $container = array();
        $harga_penerimaan=0;
        $total_harga_penerimaan=0;
        $total_harga_pengeluaran=0;
        $harga_pengeluaran=0;
        $harga_stok=0;
        $stok_gudang=0;
        $stok_penerimaan=0;
        $stok_pengeluaran =0;
        $sisa_barang=0;
        $total_jumlah_pengeluaran=0;

        $sisa_stok=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('user_id', Session::get('user_id'))->where('fiscal_years_id', $tahun_anggaran->id)->first();
            $mutasi_modal = DB::table('mutasi')
                ->leftJoin('expenditures','expenditures.id','=', 'mutasi.expenditures_id')
                ->leftJoin('goodreceipt','mutasi.goodreceipt_id','=','goodreceipt.id')
                ->select('mutasi.*', DB::raw("concat_ws('',goodreceipt.id, expenditures.goodreceipt_id) as kumpulan_id"))
                ->where('mutasi.user_id', Session::get('user_id'))
                ->where('mutasi.warehouse_id', $barang_gudang->id)
                ->whereYear('tgl_transaksi', $tahun_anggaran->years)
                ->orderBy('tgl_transaksi', 'asc')
                ->orderBy('kumpulan_id', 'asc')
                ->orderBy('id', 'asc')->get();

            if (!empty($ambil_stokbarang_lalu->stock)) {
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
                $harga_stok_kemarin = $ambil_stokbarang_lalu->harga_satuan_stok;
            } else {
                $sisa_stok_kemarin = 0;
                $harga_stok_kemarin = 0;
            }

            foreach ($mutasi_modal as $key => $data) {
                $row = array();
                $jenis_barang = jenis_barang::find($barang_gudang->typeofgoods_id);
                if($key==0 && $data->goodreceipt_id !=0)
                {
                    $stok_gudang = $sisa_stok_kemarin;
                    $harga_stok = $stok_gudang*$harga_stok_kemarin;
                    $penerimaan_barang = penerimaan::find($data->goodreceipt_id);
                    $stok_penerimaan = $data->jum_in;
                    $harga_penerimaan = $penerimaan_barang->unitPrice;
                    $harga_pengeluaran=0;
                    $stok_pengeluaran =0;
                    $total_harga_pengeluaran=0;
                    $total_harga_penerimaan = $harga_penerimaan* $penerimaan_barang->amountOfgoods;
                    $sisa_barang = $stok_gudang+$penerimaan_barang->amountOfgoods;
                    $total_jumlah_pengeluaran = $harga_stok+$total_harga_penerimaan;
                }else if($data->goodreceipt_id !=0){
                    $stok_pengeluaran =0;
                    $harga_pengeluaran=0;
                    $total_harga_pengeluaran=0;

                    $penerimaan_barang = penerimaan::find($data->goodreceipt_id);
                    $stok_penerimaan=$data->jum_in;
                    $harga_penerimaan = $penerimaan_barang->unitPrice;
                    $total_harga_penerimaan = $harga_penerimaan* $penerimaan_barang->amountOfgoods;
                    $sisa_barang += $stok_penerimaan;
                    $total_jumlah_pengeluaran +=$total_harga_penerimaan;
                }

                if($key==0 && $data->expenditures_id !=0)
                {
                    $sisa_stok = $sisa_stok_kemarin;
                    $stok_gudang = $sisa_stok_kemarin;
                    $harga_stok = $stok_gudang*$harga_stok_kemarin;
                    $stok_pengeluaran = $data->jum_out;

                    $data_pengeluaran=pengeluaran::find($data->expenditures_id);
                    $penerimaan_barang = penerimaan::find($data_pengeluaran->goodreceipt_id);

                    if($sisa_stok <= 0){
                        $harga_pengeluaran = $penerimaan_barang->unitPrice;
                    }else if($sisa_stok > 0){
                        $harga_pengeluaran = $ambil_stokbarang_lalu->harga_satuan_stok;
                    }

                    $total_harga_pengeluaran = $stok_pengeluaran * $harga_pengeluaran;
                    $sisa_barang = $sisa_stok-$stok_pengeluaran;
                    $total_jumlah_pengeluaran = $harga_stok-$total_harga_pengeluaran;

                }else if($data->expenditures_id !=0){
                    $stok_pengeluaran = $data->jum_out;
                    $sisa_stok -=$stok_pengeluaran;
                    $sisa_stok_kemarin-=$stok_pengeluaran;

                    $stok_penerimaan = 0;
                    $harga_penerimaan = 0;
                    $total_harga_penerimaan = 0;

                    $data_pengeluaran=pengeluaran::find($data->expenditures_id);
                    $penerimaan_barang = penerimaan::find($data_pengeluaran->goodreceipt_id);

                    if($sisa_stok < 0){
                        $harga_pengeluaran = $penerimaan_barang->unitPrice;
                    }else if($sisa_stok > 0){
                        $harga_pengeluaran =$harga_stok_kemarin;
                    }

                    $total_harga_pengeluaran = $stok_pengeluaran * $harga_pengeluaran;
                    $sisa_barang -= $stok_pengeluaran;
                    if(sprintf("%.3f", $sisa_barang)=="-0.00"){
                        $sisa_barang =0;
                    }
                    $total_jumlah_pengeluaran -=$total_harga_pengeluaran;

                    if(sprintf("%.3f", $total_jumlah_pengeluaran)=="-0.00"){
                        $total_jumlah_pengeluaran =0;
                    }
                }


                if($jenis_barang->formula==1){
                    $harga_stok = round($harga_stok, -3);
                    $harga_penerimaan = round($harga_penerimaan, -3);
                    $total_harga_penerimaan = round($total_harga_penerimaan, -3);
                    $harga_pengeluaran = round($harga_pengeluaran, -3);
                    $total_harga_pengeluaran = round($total_harga_pengeluaran, -3);
                    $total_jumlah_pengeluaran = round($total_jumlah_pengeluaran, -3);
                }

                if($data->tgl_transaksi >= $tanggal_awal && $data->tgl_transaksi <= $tanggal_akhir) {
                    $row[] = '<th class="no">0</th>';
                    $row[] =  date('d-m-Y', strtotime($data->tgl_transaksi));
                    $row[] = $barang_gudang->goods_name . ', ' . $barang_gudang->specs. ', ' . $barang_gudang->brand;
                    //======================== Barang ======================================
                    $row[] = number_format($stok_gudang, 2, ',', '.');
                    $row[] = $barang_gudang->unit;
                    $row[] = number_format($harga_stok, 2, ',', '.');

                    //penerimaan
                    $row[] = number_format($stok_penerimaan, 2, ',', '.');
                    $row[] = number_format($harga_penerimaan, 2, ',', '.');
                    $row[] = number_format($total_harga_penerimaan, 2, ',', '.');
                    //pengeluaran
                    $row[] = number_format($stok_pengeluaran, 2, ',', '.');
                    $row[] = number_format($harga_pengeluaran, 2, ',', '.');
                    $row[] = number_format($total_harga_pengeluaran, 2, ',', '.');

                    //sisa
                    $row[] = number_format($sisa_barang, 2, '.', '.');
                    $row[] = number_format($total_jumlah_pengeluaran, 2, '.', '.');
                    $container[] = $row;


                }
                $stok_gudang = $sisa_barang;
                $harga_stok = $total_jumlah_pengeluaran;
                $sisa_stok = $sisa_stok_kemarin;
            }
        }

        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        //seleksi perbulan
        $explode_tgl_awal = explode('-',$tanggal_awal);
        $explode_tgl_akhir = explode('-',$tanggal_akhir);
        $bulan="";
        if($explode_tgl_awal[1]==$explode_tgl_akhir[1]){
            $bulan= $this->bulan($explode_tgl_akhir[1]);
        }

        $output = array('data'=> $container, 'instansi'=> $instansi, 'zona'=> $wilaya,'atasan_langsung'=> $atasan_langsung,'bulan'=>$bulan,'thn_anggaran'=>$tahun_anggaran->years,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date);

        if($ext==1){
            return view('content2.report.report_mutasi', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function pembulatan($uang){
        $ratusan = substr($uang, -3);
        if($ratusan<500)
            $akhir = $uang - $ratusan;
        else
            $akhir = $uang + (1000-$ratusan);

        return $akhir;
    }

    public function set_mutasi_bpk(Request $req){

//        $mutasi_modal = mutasi::all()->where('tgl_transaksi','>=', $tanggal_awal)->where('tgl_transaksi','<=', $tanggal_akhir)->where('user_id',  Session::get('user_id'));


        $this->validate($req,[
            'first_date' => 'required',
            'last_date' => 'required',
            'print_date' => 'required',
            'ext' => 'required'
        ]);

        $ext = $req->ext;
        $tanggal_awal = date('Y-m-d', strtotime($req->first_date));
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));
        $print_date = date('Y-m-d', strtotime($req->print_date));

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();


        if($req->warehouse_id1 != 0){
            $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
                ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
                ->select('warehouse.id','warehouse.initial_stock','warehouse.typeofgoods_id','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit')
                ->where('warehouse.user_id',Session::get('user_id'))
                ->where('mutasi.warehouse_id', $req->warehouse_id1)
                ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
                ->groupBy('warehouse.id')
                ->get();
        }else if($req->jenis_barang !=0){
            $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
                ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
                ->select('warehouse.id','warehouse.initial_stock','warehouse.typeofgoods_id','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit')
                ->where('warehouse.user_id',Session::get('user_id'))
                ->where('warehouse.typeofgoods_id', $req->jenis_barang)
                ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
                ->groupBy('warehouse.id')
                ->get();
        }else{
            $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
                ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
                ->select('warehouse.id','warehouse.initial_stock','warehouse.typeofgoods_id','warehouse.specs','warehouse.brand','warehouse.goods_name','warehouse.unit')
                ->where('warehouse.user_id',Session::get('user_id'))
                ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
                ->groupBy('warehouse.id')
                ->get();
        }



        $container = array();
        $harga_penerimaan=0;
        $total_harga_penerimaan=0;
        $total_harga_pengeluaran=0;
        $harga_pengeluaran=0;
        $harga_stok=0;
        $stok_gudang=0;
        $stok_penerimaan=0;
        $stok_pengeluaran =0;
        $sisa_barang=0;
        $total_jumlah_pengeluaran=0;

        $sisa_stok=0;

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang_gudang) {
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang_gudang->id)->where('fiscal_years_id', $tahun_anggaran->id)->first();
            $mutasi_modal = DB::table('mutasi')
                ->leftJoin('expenditures','expenditures.id','=', 'mutasi.expenditures_id')
                ->leftJoin('goodreceipt','mutasi.goodreceipt_id','=','goodreceipt.id')
                ->select('mutasi.*', DB::raw("concat_ws('',goodreceipt.id, expenditures.goodreceipt_id) as kumpulan_id"))
                ->where('mutasi.user_id', Session::get('user_id'))
                ->where('mutasi.warehouse_id', $barang_gudang->id)
                ->whereYear('tgl_transaksi', $tahun_anggaran->years)
                ->orderBy('tgl_transaksi', 'asc')
                ->orderBy('kumpulan_id', 'asc')
                ->orderBy('id', 'asc')->get();

            if (!empty($ambil_stokbarang_lalu->stock)) {
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
                $harga_stok_kemarin = $ambil_stokbarang_lalu->harga_satuan_stok;
            } else {
                $sisa_stok_kemarin = 0;
                $harga_stok_kemarin = 0;
            }

            foreach ($mutasi_modal as $key => $data) {
                $row = array();

                if($key==0 && $data->goodreceipt_id !=0)
                {
                    $stok_gudang = $sisa_stok_kemarin;
                    $harga_stok = $stok_gudang*$harga_stok_kemarin;
                    $penerimaan_barang = penerimaan::find($data->goodreceipt_id);
                    $stok_penerimaan = $data->jum_in;
                    $harga_penerimaan = $penerimaan_barang->unitPrice;
                    $harga_pengeluaran=0;
                    $stok_pengeluaran =0;
                    $total_harga_pengeluaran=0;
                    $total_harga_penerimaan = $harga_penerimaan* $penerimaan_barang->amountOfgoods;
                    $sisa_barang = $stok_gudang+$penerimaan_barang->amountOfgoods;
                    $total_jumlah_pengeluaran = $harga_stok+$total_harga_penerimaan;
                }else if($data->goodreceipt_id !=0){
                    $stok_pengeluaran =0;
                    $harga_pengeluaran=0;
                    $total_harga_pengeluaran=0;

                    $penerimaan_barang = penerimaan::find($data->goodreceipt_id);
                    $stok_penerimaan=$data->jum_in;
                    $harga_penerimaan = $penerimaan_barang->unitPrice;
                    $total_harga_penerimaan = $harga_penerimaan* $penerimaan_barang->amountOfgoods;
                    $sisa_barang += $stok_penerimaan;
                    $total_jumlah_pengeluaran +=$total_harga_penerimaan;
                }

                if($key==0 && $data->expenditures_id !=0)
                {
                    $sisa_stok = $sisa_stok_kemarin;
                    $stok_gudang = $sisa_stok_kemarin;
                    $harga_stok = $stok_gudang*$harga_stok_kemarin;
                    $stok_pengeluaran = $data->jum_out;

                    $data_pengeluaran=pengeluaran::find($data->expenditures_id);
                    $penerimaan_barang = penerimaan::find($data_pengeluaran->goodreceipt_id);

                    if($sisa_stok <= 0){
                        $harga_pengeluaran = $penerimaan_barang->unitPrice;
                    }else if($sisa_stok > 0){
                        $harga_pengeluaran = $ambil_stokbarang_lalu->harga_satuan_stok;
                    }

                    $total_harga_pengeluaran = $stok_pengeluaran * $harga_pengeluaran;
                    $sisa_barang = $sisa_stok-$stok_pengeluaran;
                    $total_jumlah_pengeluaran = $harga_stok-$total_harga_pengeluaran;

                }else if($data->expenditures_id !=0){
                    $stok_pengeluaran = $data->jum_out;
                    $sisa_stok -=$stok_pengeluaran;
                    $sisa_stok_kemarin-=$stok_pengeluaran;

                    $stok_penerimaan = 0;
                    $harga_penerimaan = 0;
                    $total_harga_penerimaan = 0;

                    $data_pengeluaran=pengeluaran::find($data->expenditures_id);
                    $penerimaan_barang = penerimaan::find($data_pengeluaran->goodreceipt_id);

                    if($sisa_stok < 0){
                        $harga_pengeluaran = $penerimaan_barang->unitPrice;
                    }else if($sisa_stok > 0){
                        $harga_pengeluaran =$harga_stok_kemarin;
                    }

                    $total_harga_pengeluaran = $stok_pengeluaran * $harga_pengeluaran;
                    $sisa_barang -= $stok_pengeluaran;
                    $total_jumlah_pengeluaran -=$total_harga_pengeluaran;

                    if(sprintf("%.3f", $sisa_barang)=="-0.00"){
                        $sisa_barang =0;
                    }
                    $total_jumlah_pengeluaran -=$total_harga_pengeluaran;

                    if(sprintf("%.3f", $total_jumlah_pengeluaran)=="-0.00"){
                        $total_jumlah_pengeluaran =0;
                    }
                }

                $jenis_barang = jenis_barang::find($barang_gudang->typeofgoods_id);
                if($jenis_barang->formula==1){
                    $harga_stok = round($harga_stok, -3);
                    $harga_penerimaan = round($harga_penerimaan, -3);
                    $total_harga_penerimaan = round($total_harga_penerimaan, -3);
                    $harga_pengeluaran = round($harga_pengeluaran, -3);
                    $total_harga_pengeluaran = round($total_harga_pengeluaran, -3);
                    $total_jumlah_pengeluaran = round($total_jumlah_pengeluaran, -3);
                }

                if($data->tgl_transaksi >= $tanggal_awal && $data->tgl_transaksi <= $tanggal_akhir) {
                    $row[] = '<th class="no">0</th>';
                    $row[] =  date('d-m-Y', strtotime($data->tgl_transaksi)) ;
                    $row[] = $barang_gudang->goods_name . ', ' . $barang_gudang->specs. ', ' . $barang_gudang->brand;
                    //======================== Barang ======================================
                    $row[] = number_format($stok_gudang, 2, ',', '.');
                    $row[] = $barang_gudang->unit;
                    $row[] = number_format($harga_stok, 2, ',', '.');

                    //penerimaan
                    $row[] = number_format($stok_penerimaan, 2, ',', '.');
                    $row[] = number_format($harga_penerimaan, 2, ',', '.');
                    $row[] = number_format($total_harga_penerimaan, 2, ',', '.');
                    //pengeluaran
                    $row[] = number_format($stok_pengeluaran, 2, ',', '.');
                    $row[] = number_format($harga_pengeluaran, 2, ',', '.');
                    $row[] = number_format($total_harga_pengeluaran, 2, ',', '.');

                    //sisa
                    $row[] = number_format($sisa_barang, 2, ',', '.');
                    $row[] = number_format($total_jumlah_pengeluaran, 2, ',', '.');
                    $container[] = $row;


                }
                $stok_gudang = $sisa_barang;
                $harga_stok = $total_jumlah_pengeluaran;
                $sisa_stok = $sisa_stok_kemarin;
            }
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $explode_tgl_awal = explode('-',$tanggal_awal);
        $explode_tgl_akhir = explode('-',$tanggal_akhir);
        $bulan="";
        if($explode_tgl_awal[1]==$explode_tgl_akhir[1]){
            $bulan= $this->bulan($explode_tgl_akhir[1]);
        }
        $output = array('data'=> $container, 'instansi'=> $instansi, 'zona'=> $wilaya,'atasan_langsung'=> $atasan_langsung,'bulan'=>$bulan,'thn_anggaran'=>$tahun_anggaran->years,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$print_date);

        if($ext==1){
            return view('content_pbpk.report.report_mutasi', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function bulan($number_moon=""){

        if($number_moon==1){
            $number_moon2="JANUARI";
        }else if($number_moon==2){
            $number_moon2="FEBRUARI";
        }else if($number_moon==3){
            $number_moon2="MARET";
        }else if($number_moon==4){
            $number_moon2="APRIL";
        }else if($number_moon==5){
            $number_moon2="MEI";
        }else if($number_moon==6){
            $number_moon2="JUNI";
        }else if($number_moon==7){
            $number_moon2="JULI";
        }else if($number_moon==8){
            $number_moon2="AGUSTUS";
        }else if($number_moon==9){
            $number_moon2="SEPTEMBER";
        }else if($number_moon==10){
            $number_moon2="OKTOBER";
        }else if($number_moon==11){
            $number_moon2="NOVEMBER";
        }else if($number_moon==12){
            $number_moon2="DESEMBER";
        }
        return $number_moon2;
    }

    public function get_stok_goods_(){
        return view('content2.report.report_stok_barang_content');
    }

    public function get_bpk_stok_goods_(){
        return view('content_pbpk.report.report_stok_barang_content');
    }
    public function get_pemprov_stok_goods_(){
        return view('content_pInspektorat.report.report_stok_barang_content');
    }
    public function get_pemkot_stok_goods_(){
        return view('content_pInspektorat_pemkot.report.report_stok_barang_content');
    }
    public function get_pemkab_stok_goods_(){
        return view('content_pInspektorat_pemkab.report.report_stok_barang_content');
    }

    public function get_stok_opname_content(){
        return view('content2.report.report_stok_opname_content');
    }

    public function get_bpk_stok_opname_content(){
        return view('content_pbpk.report.report_stok_opname_content');
    }

    public function get_pemprov_stok_opname_content(){
        return view('content_pInspektorat.report.report_stok_opname_content');
    }
    public function get_pemkot_stok_opname_content(){
        return view('content_pInspektorat_pemkot.report.report_stok_opname_content');
    }
    public function get_pemkab_stok_opname_content(){
        return view('content_pInspektorat_pemkot.report.report_stok_opname_content');
    }

    public function get_stok_goods(){

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();

        $data_penerimaan = penerimaan::where('user_id', Session::get('user_id'))->whereRaw('year(dateOfpurchase)', [$tahun_anggaran->years-2, $tahun_anggaran->years])->get();
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
        $output = array('data'=> $container);
        return $output;
    }

    public function set_stok_goods(Request $req){

        $this->validate($req,[
            'ext' => 'required',
            'last_date' => 'required',
        ]);

        $ext = $req->ext;
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();



        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();
        $output = array('data'=> $this->get_stok_goods()['dari'], 'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$tanggal_akhir);

        if($ext==1){
            return view('content2.report.report_stok_barang', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function set_bpk_stok_goods(Request $req){

        $this->validate($req,[
            'ext' => 'required',
            'last_date' => 'required',
        ]);

        $ext = $req->ext;
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();

        $ambil_stok_gudang_yang_ada_didalam_mutasi = DB::table('mutasi')
            ->join('warehouse','warehouse.id','=','mutasi.warehouse_id')
            ->select('warehouse.id','warehouse.initial_stock','warehouse.brand','warehouse.specs','warehouse.goods_name','warehouse.unit')
            ->where('warehouse.user_id',Session::get('user_id'))
            ->whereYear('mutasi.tgl_transaksi', $tahun_anggaran->years)
            ->groupBy('warehouse.id')
            ->get();

        $no = 1;
        $container =array();

        foreach ($ambil_stok_gudang_yang_ada_didalam_mutasi as $barang){
            $ambil_stokbarang_lalu = stok_lalu::where('warehouse_id', $barang->id)->where('fiscal_years_id',$tahun_anggaran->id)->first();

            if(!empty($ambil_stokbarang_lalu->stock)){
                $sisa_stok_kemarin = $ambil_stokbarang_lalu->stock;
            }else{
                $sisa_stok_kemarin = 0;
            }

            $jumlah_barang_penerimaan = penerimaan::where('warehouse_id', $barang->id)->whereYear('dateOfpurchase',$tahun_anggaran->years)->sum('amountOfgoods');
            $jumlah_barang_pengeluaran = pengeluaran::where('warehouse_id', $barang->id)->whereYear('out_date',$tahun_anggaran->years)->sum('exit_item');

            $row =array();
            $row[]=$no++;
            $row[]=$barang->goods_name.', '.$barang->specs;
            $row[]=$barang->unit;
            $row[]=$barang->brand;

            $jumlah_stok = ($sisa_stok_kemarin + $jumlah_barang_penerimaan)-$jumlah_barang_pengeluaran;

            $row[]=$jumlah_stok;

            if($jumlah_stok ==0 ){
                $ket = "Barang tidak tersedia";
            }else{
                $ket = "Barang masih tersedia";
            }
            $row[]=$ket;

            $container[]= $row;
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();
        $output = array('data'=> $container, 'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$tanggal_akhir);

        if($ext==1){
            return view('content_pbpk.report.report_stok_barang', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function get_stok_opname(){
        $output = array('data'=> $this->get_new_stok_opname()['data'],'total_seluruh_stok'=>$this->get_new_stok_opname()['total_seluruh_stok']);
        return response()->json($output);
    }
   //===================================================================================================================

    public function get_new_stok_opname(){
        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();

        $data_penerimaan = penerimaan::where('user_id', Session::get('user_id'))->whereRaw('year(dateOfpurchase)', [$tahun_anggaran->years-2, $tahun_anggaran->years])->get();
        $container=array();
        $seluruh_stok=0;
        $no=1;
        foreach ($data_penerimaan as $data_penerimaan)
        {
            $row = array();
            $stok = $data_penerimaan->amountOfgoods - $data_penerimaan->getExpendures->sum('exit_item');
           if($stok !=0){
               $row[]=  $no++;
               $row[]=  $data_penerimaan->getGoods->goods_name.', '.$data_penerimaan->specs.' Tahun Anggaran :'.date('Y', strtotime($data_penerimaan->dateOfpurchase));
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


    public function set_stok_opname(Request $req){

        $this->validate($req,[
            'ext' => 'required',
            'last_date' => 'required',
        ]);

        $ext = $req->ext;
        $tanggal_akhir = date('Y-m-d', strtotime($req->last_date));

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();
        $output = array('data'=> $this->get_new_stok_opname()['data'],'total_seluruh_stok'=>$this->get_new_stok_opname()['total_seluruh_stok'], 'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$tanggal_akhir);

        if($ext==1){
            return view('content2.report.report_stok_opname', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function get_stok_opname_cek_base_jenis_barang(){

        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        $container =array();
        $container_cek =array();
        $jumlah_seluruh=0;
        $no=1;
        foreach ($jenis_barang as $jenis_barang){
            $row = [];
            $penerimaan_gundang = gudang::all()->where('typeofgoods_id', $jenis_barang->id);
            $total_uang = 0;

            foreach ($penerimaan_gundang as $data){

                foreach ($data->goodMannyReceipt as $id_goodReceip=> $datas){

                    $total_pengeluaran = 0;
                    if(!empty($datas->getExpendures)){
                        $total_pengeluaran = $datas->getExpendures->sum('exit_item');
                    }
                    $data_pengeluaran = $total_pengeluaran;
                    $jumlah_uang = $datas->unitPrice*($datas->amountOfgoods-$data_pengeluaran);
                    $total_uang += $jumlah_uang;
                }
            }

            $row[]= $no++ ;
            $row[]= $jenis_barang->typeOfGoods;
            $jumlah_seluruh+=$total_uang;
            $row[]= number_format($total_uang,2,',','.');
            $container[]= $row;
        }


        $output = array('data'=>$container,'jumlah_total_stok_opname'=>$jumlah_seluruh, 'container_cek'=> $container_cek);
        return $output;
    }



    //============================= Form Mutasi Tambah Kurang ==========================================================

    public function format_permintaan_bpk_content(){
        return view('content2.report.report_rekaputulasi_perjenis_barang_content_k_bpk', $this->format_permintaan_bpk());
    }

    public function format_permintaan_bpk(){
        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();

        $data_penerimaan_lalu = penerimaan::whereYear('dateOfpurchase',$tahun_anggaran->years-1)->where('user_id', Session::get('user_id'))->get();
        $data_penerimaan_mendatang = penerimaan::whereYear('dateOfpurchase',$tahun_anggaran->years)->where('user_id', Session::get('user_id'))->get();
        $data_jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        $container_jenis_barang = array();
        $no = 1;
        $total_neraca_tahun_lalu=0;
        $total_persediaan_tahun_berjalan=0;
        $total_pengeluaran_tahun_berjalan=0;
        $total_persediaan_akhir_tahun=0;

        foreach ($data_jenis_barang as $jenis_barang){
            $array_jenis_barang = array();
            $total_perjenis_barang = 0;
            $data_cont=array();

            $total_perjenis_penerimaan_thn_akan_datang = 0;
            $total_perjenis_pengeluaran_thn_akan_datang = 0;
            $selisih = 0;
            foreach ($data_penerimaan_lalu as $data_penerimaans){
                    $i=0;
                    foreach ($data_penerimaans->getExpendures->groupBy('goodreceipt_id') as $key=> $data_pengeluaran){
                        if($data_pengeluaran[$i]->get_warehouse()->first()->typeofgoods_id==$jenis_barang->id){
                             $data_pengeluaran_tahun_lalu = $data_pengeluaran[$i]->whereYear('out_date', $tahun_anggaran->years-1)->groupBy('goodreceipt_id')->sum('exit_item');
                             $stok_lalu = $data_penerimaans->amountOfgoods-$data_pengeluaran_tahun_lalu;
                             $harga_satuan = $data_penerimaans->unitPrice * $stok_lalu;
                             $cek_selisih_antara_total_penerimaan = $data_penerimaans->totalPrice - $harga_satuan;
                             $total_penerimaan_ditambahkan_dgn_selisih = $data_penerimaans->totalPrice+$cek_selisih_antara_total_penerimaan;
                             $total_perjenis_barang += $total_penerimaan_ditambahkan_dgn_selisih;
                        }
                        $i++;
                    }

            }

            foreach ($data_penerimaan_mendatang as $item) {
                if($item->getGoods->typeofgoods_id==$jenis_barang->id){
                    $total_perjenis_penerimaan_thn_akan_datang += $item->totalPrice;
                    foreach ($item->getExpendures->groupBy('goodreceipt_id') as $data_pengeluaran){
                        $total_barang_keluar = $data_pengeluaran->sum('exit_item');
                        $total_pengeluaran_kli_harga_penerimaan = $item->unitPrice * $total_barang_keluar;
                        $selisih_total_price_dikurangi_total_pengeluaran_kli_total_harga_penerimaan = ($total_pengeluaran_kli_harga_penerimaan-$item->totalPrice)*1;

                        $jumlah_total_pengeluaran_ples_selisih = $total_pengeluaran_kli_harga_penerimaan;
                        $total_perjenis_pengeluaran_thn_akan_datang +=$jumlah_total_pengeluaran_ples_selisih;
                        $selisih +=$selisih_total_price_dikurangi_total_pengeluaran_kli_total_harga_penerimaan;
                    }
                }
            }


            $persediaan_akhir_desember_per_tahun = ($total_perjenis_barang+$total_perjenis_penerimaan_thn_akan_datang)-($total_perjenis_pengeluaran_thn_akan_datang-$selisih);
            $array_jenis_barang[] =$no++;
            $array_jenis_barang[] = $jenis_barang->typeOfGoods;
            $array_jenis_barang[] = number_format($total_perjenis_barang,2,',','.');
            $array_jenis_barang[] = number_format($total_perjenis_penerimaan_thn_akan_datang,2,',','.');
            $array_jenis_barang[] = number_format($total_perjenis_pengeluaran_thn_akan_datang-$selisih,2,',','.');
            $array_jenis_barang[] = number_format($persediaan_akhir_desember_per_tahun,2,',','.');
            $container_jenis_barang[] = $array_jenis_barang;

            $total_neraca_tahun_lalu += $total_perjenis_barang;
            $total_persediaan_tahun_berjalan += $total_perjenis_penerimaan_thn_akan_datang;
            $total_pengeluaran_tahun_berjalan += $total_perjenis_pengeluaran_thn_akan_datang;
            $total_persediaan_akhir_tahun += $persediaan_akhir_desember_per_tahun;

        }


        return array('data'=>$container_jenis_barang,
            'total_neraca_tahun_lalu'=>$total_neraca_tahun_lalu,
            'total_persediaan_di_lra'=>$total_persediaan_tahun_berjalan,
            'total_pengeluaran'=>$total_pengeluaran_tahun_berjalan,
            'total_pesediaan_akhir_tahun'=>$total_persediaan_akhir_tahun,
            'tahun_anggaran'=> $tahun_anggaran->years);
    }



    public function print_mutasi_tambah_kurang(Request $req){
        $this->validate($req, [
            'tanggal_cetak'=>'required'
        ]);
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $data = [
            'instansi'=>$instansi,
            'data'=>$this->format_permintaan_bpk(),
            'atasan_langsung'=> $atasan_langsung,
            'penyimpan_barang'=> $penyimpan_barang,
            'tgl_cetak'=> $req->tanggal_cetak
        ];
        return view('content2.report.report_mutasi_tambah_kurang_per_jenis_barang',$data);
    }
}
