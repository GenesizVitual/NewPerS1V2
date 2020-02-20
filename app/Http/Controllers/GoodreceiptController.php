<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Session;

use App\Tbk as tbk;

use App\Warehouse as gudang;

use App\Suppliers as supplier;

use App\Goodreceipt as goodsreceipt;

use App\Goodreceipt as penerimaan;

use App\Expenditures as exspediture;

use App\Authorized as berwanang;

use App\Mutasi as mutasi;

use App\Instance as instansi;

use App\Province as provinsi;

use App\typeOfGoods as jenis_barang;

use App\Fiscal_years as tahun_anggaran;

use App\Spj as spj;

use App\Rincian_barang_model as rincian_barang;

use Redirect;

use Carbon\Carbon;

class GoodreceiptController extends Controller
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


    public function listReceipt($id)
    {
        $pass = $this->property($id, null);
        return view('content2.page_goodreceipt.index', $pass);
    }

    public function store($id, Request $req)
    {
        $master_id =Session::get('user_id');
        $id_barang = $req->warehouse_id;
        $this->validate($req,[
            'dateOfpurchase'=> 'required',
            'warehouse_id'=> 'required',
            'amountOfgoods' => 'required',
            'unitPrice' => 'required',
            'suppliers_id' => 'required',
        ]);

        $tanggal_penerimaan = date('Y-m-d', strtotime($req->dateOfpurchase));

        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', $master_id)->where('status', '1')->first();
        $explode_tahun = explode('-', $tanggal_penerimaan);

        if($explode_tahun[0]!=$tahun_anggaran_aktiv->years){
            $feedback = array(
                'status'=> false,
                'info'=> 'Tahun pada tanggal beli tidak sesuai dengan tahun anggaran yang aktif'
            );
            return $feedback;
        }

        $gudang = gudang::find($id_barang);
        $jenis_barang_model= jenis_barang::find($gudang->typeofgoods_id);


        $harga_barang= $req->unitPrice;
        $supplier = $req->suppliers_id;
        $no_factur = $req->no_factur;

        $tanggal_factur = date('Y-m-d', strtotime($req->date_factur));


        if($harga_barang > $gudang->standard_price){
            $feedback = array(
                'status'=> false,
                'info'=> 'Harga barang melebihi standar harga barang'
            );

            return $feedback;
        }

        $banyak_barang =$req->amountOfgoods;

        if($jenis_barang_model->formula=='1'){
            $harga_totals =round($banyak_barang*$harga_barang, -3) ;
            $harga_mutasi = round($banyak_barang*$harga_barang, -3) ;
        }else{
            $harga_totals =$banyak_barang*$harga_barang;
            $harga_mutasi = $banyak_barang*$harga_barang;
        }

        $penerimaan = new goodsreceipt([
           'dateOfpurchase' => $tanggal_penerimaan,
            'warehouse_id' => $id_barang,
            'unitPrice'=>$harga_barang,
            'amountOfgoods'=>$banyak_barang,
            'suppliers_id'=>$supplier,
            'nomor_factur' => $no_factur,
            'date_factur' => $tanggal_factur,
            'totalPrice' =>$harga_totals,
            'tbk_id'=>$id,
            'status'=>$jenis_barang_model->formula,
            'user_id'=>$master_id
        ]);


        $barang_sekaranng = $gudang->initial_stock;
        $barang_total_harga =$gudang->total_price ;
        if($penerimaan->save()){

            $mutasi = new mutasi([
                'tgl_transaksi' =>$tanggal_penerimaan,
                'warehouse_id' => $id_barang,
                'goodreceipt_id'=>$penerimaan->id,
                'expenditures_id'=>0,
                'last_stock' =>$barang_sekaranng,
                'jum_in'=>$banyak_barang,
                'jum_out'=>0,
                'remaining_stok'=>$barang_sekaranng+$banyak_barang,
                'total_start'=>$barang_total_harga,
                'total_final'=>$harga_mutasi,
                'total'=>0,
                'user_id'=> $master_id
            ]);
            $mutasi->save();

            $feedback = array(
                'status'=> true,
                'info'=> 'Data penerimaan berhasil di tambahkan'
            );

            return response()->json($feedback);

        }else{
            $feedback = array(
                'status'=> true,
                'info'=> 'Data penerimaan gagal disimpan'
            );
            return response()->json($feedback);
        }
        return response()->json('');
    }

    public function Multistore(Request $req)
    {
       // dd($req->all());
        $this->validate($req,[
            'id_supplier' => 'required',
            'tgl_penerimaan' => 'required',
            'id_rincian_barang' => 'required',
            'nomor_surat' => 'required',
        ]);

        $tbk_id=$req->tbk_id;
        $spj_id=$req->spj_id;
        $no_surat=$req->nomor_surat;
        $id_supplier=$req->id_supplier;
        $tgl_penerimaan=$req->tgl_penerimaan;
        $id_rincian_barang=$req->id_rincian_barang;

        if($spj_id==0 && $tbk_id==0){
            $buat_spj_baru = spj::firstOrNew(array('number_spj' => $no_surat));
            $buat_spj_baru->user_id = Session::get('user_id');
            if($buat_spj_baru->save()){
                $buat_tbk_baru =  tbk::firstOrNew(array('number_tbk' => $no_surat));
                $buat_tbk_baru->spj_id= $buat_spj_baru->id;
                $buat_tbk_baru->user_id= Session::get('user_id');
                if($buat_tbk_baru->save()){
                    $status=$this->SubMultistore($id_rincian_barang, $buat_tbk_baru->id,$tgl_penerimaan,$id_supplier);
                }
            }
        }else if($tbk_id==0){
                $buat_tbk_baru =  tbk::firstOrNew(array('number_tbk' => $no_surat));
                $buat_tbk_baru->spj_id= $spj_id;
                $buat_tbk_baru->user_id= Session::get('user_id');
                if($buat_tbk_baru->save()){
                    $status=$this->SubMultistore($id_rincian_barang, $buat_tbk_baru->id,$tgl_penerimaan,$id_supplier);
                }
        }else{
            $status=$this->SubMultistore($id_rincian_barang,$tbk_id,$tgl_penerimaan,$id_supplier);
        }
        return response()->json($status);
    }

    public function SubMultistore($id_rincian_barang, $id_tbk, $tgl_penerimaan,$id_supplier){
        $pecahkahRincian_barang = explode(',',$id_rincian_barang);
        $pesan=array();
        foreach ($pecahkahRincian_barang as $id_rincian_barang){
            $data_rincian_barang = rincian_barang::find($id_rincian_barang);
            $warehouse_id = $data_rincian_barang->id_barang;
            $unitPrice= $data_rincian_barang->harga_satuan;
            $suppliers_id= $id_supplier;
            $no_factur= "";
            $date_factur= Carbon::now();
            $amountOfgoods=$data_rincian_barang->quntitas;
            $cek_dataSUdah_diimport = goodsreceipt::where('id_rincian_barang', $id_rincian_barang)
                ->join('tbk','tbk.id','=','goodreceipt.tbk_id')
                ->join('spj','spj.id','=','tbk.spj_id')
                ->count();
            if($cek_dataSUdah_diimport == 0){
                $pesan[] =$this->proses($id_rincian_barang, $tgl_penerimaan,$warehouse_id,$unitPrice,$suppliers_id,$no_factur,$date_factur,$amountOfgoods,$id_tbk);
            }else{
                $pesan[] = "Barang ini telah diimport adalah:" . $data_rincian_barang->get_barang->goods_name;
            }
        }
        return $pesan;
    }

    public function proses($id_rincian_barang,$tgl_penerimaan,$warehouse_id, $unitPrice, $suppliers_id,$no_factur, $date_factur,$amountOfgoods,$id_tbk){
        $tanggal_penerimaan = date('Y-m-d', strtotime($tgl_penerimaan));
        $master_id =Session::get('user_id');
        $id_barang = $warehouse_id;
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', $master_id)->where('status', '1')->first();
        $explode_tahun = explode('-', $tanggal_penerimaan);

        $gudang = gudang::find($id_barang);
        $jenis_barang_model= jenis_barang::find($gudang->typeofgoods_id);

        $harga_barang= $unitPrice;
        $supplier =$suppliers_id;
        $no_factur = $no_factur;

        $tanggal_factur = date('Y-m-d', strtotime($date_factur));

        $banyak_barang =$amountOfgoods;
        if($jenis_barang_model->formula=='1'){
            $harga_totals =round($banyak_barang*$harga_barang, -3) ;
            $harga_mutasi = round($banyak_barang*$harga_barang, -3) ;
        }else{
            $harga_totals =$banyak_barang*$harga_barang;
            $harga_mutasi = $banyak_barang*$harga_barang;
        }
//        $penerimaan = goodsreceipt::firstOrNew([
//            'dateOfpurchase' => $tanggal_penerimaan,
//            'warehouse_id' => $id_barang,
//            'unitPrice'=>$harga_barang,
//            'amountOfgoods'=>$banyak_barang,
//            'suppliers_id'=>$supplier,
//            'nomor_factur' => $no_factur,
//            'date_factur' => $tanggal_factur,
//            'totalPrice' =>$harga_totals,
//            'tbk_id'=>"",
//            'user_id'=>$master_id
//        ]);
//
        $penerimaan = new goodsreceipt();
        $penerimaan->dateOfpurchase=$tanggal_penerimaan;
        $penerimaan->warehouse_id=$id_barang;
        $penerimaan->unitPrice=$harga_barang;
        $penerimaan->amountOfgoods=$banyak_barang;
        $penerimaan->suppliers_id=$supplier;
        $penerimaan->nomor_factur=$no_factur;
        $penerimaan->date_factur=$tanggal_factur;
        $penerimaan->totalPrice=$harga_totals;
        $penerimaan->tbk_id=$id_tbk;
        $penerimaan->user_id=$master_id;
        $penerimaan->status= $gudang->jenis_barang_by_type_goods->formula;
        $penerimaan->id_rincian_barang=$id_rincian_barang;

        $barang_sekaranng = $gudang->initial_stock;
        $barang_total_harga =$gudang->total_price ;
        if($penerimaan->save()){
            $mutasi = new mutasi([
                'tgl_transaksi' =>$tanggal_penerimaan,
                'warehouse_id' => $id_barang,
                'goodreceipt_id'=>$penerimaan->id,
                'expenditures_id'=>0,
                'last_stock' =>$barang_sekaranng,
                'jum_in'=>$banyak_barang,
                'jum_out'=>0,
                'remaining_stok'=>$barang_sekaranng+$banyak_barang,
                'total_start'=>$barang_total_harga,
                'total_final'=>$harga_mutasi,
                'total'=>0,
                'user_id'=> $master_id
            ]);
            $mutasi->save();
            $feedback = [ 'Barang berhasil diimport adalah :'.$gudang->goods_name];
            return $feedback;
        }

    }



    public function edit($idtbk, $idGoods){
        $pass = $this->property($idtbk, $idGoods);
        return response()->json($pass);
    }

    public function update($idGoods, Request $req)
    {
        $master_id =Session::get('user_id');

        $this->validate($req,[
            'dateOfpurchase'=> 'required',
            'warehouse_id'=> 'required',
            'amountOfgoods' => 'required',
            'unitPrice' => 'required',
            'suppliers_id' => 'required',
            'tbk_id' => 'required',
        ]);

        $tanggal_penerimaan = date('Y-m-d', strtotime($req->dateOfpurchase));

        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', $master_id)->where('status', '1')->first();
        $explode_tahun = explode('-', $tanggal_penerimaan);
        if($explode_tahun[0]!=$tahun_anggaran_aktiv->years){
            $feedback = array(
                'status'=> false,
                'info'=> 'Tahun pada tanggal beli tidak sesuai dengan tahun anggaran yang aktif'
            );

            return $feedback;
        }

        $id_barang = $req->warehouse_id;
        $harga_barang = $req->unitPrice;
        $supplier = $req->suppliers_id;
        $no_factur = $req->no_factur;
        $tbk_id = $req->tbk_id;
        $tanggal_factur = date('Y-m-d', strtotime($req->date_factur));

        //ambil stok barang yang sudah ada digudang
        $stok_gudang = gudang::find($id_barang);

        if($harga_barang > $stok_gudang->standard_price){
            $feedback = array(
                'status'=> false,
                'info'=> 'Harga barang melebihi standar harga barang'
            );

            return $feedback;
        }

        //ambil penerimaan sebelum diubah
        $model_penerimaan = goodsreceipt::find($idGoods);
        $penerimaan_barang_sebelum_diubah = $model_penerimaan->amountOfgoods;
        $jenis_barang_model= jenis_barang::find($stok_gudang->typeofgoods_id);
        //ambil nilai penerimaan barang yang akan dijadikan sebagaim penerimaan barang baru atau yang akan diubah
         //$banyak_barang = $req->amountOfgoods;

        $banyak_barang =$req->amountOfgoods;



        $stok_akhir = 0;
         if ($banyak_barang > $penerimaan_barang_sebelum_diubah){
             //mencari total yg tersedia = stok gudang + penerimaan sebelum diubah
             $tt = $stok_gudang->initial_stock+$penerimaan_barang_sebelum_diubah;

             //mencari total keseluruhan penerimaan = total tersedia + banyak barang yang diterima
             $tkp = $tt+$banyak_barang;

             //mencari total penerimaan setelah dikurangkan dengan total tersedia
             $sp = $tkp-$tt;

             //total_akhir Penerimaan
             $sa = $sp+$stok_gudang->initial_stock;
             $stok_akhir= $sa;
         }else if(($banyak_barang < $penerimaan_barang_sebelum_diubah)){
             //mencari total pengurangan
             $tx = $penerimaan_barang_sebelum_diubah+$banyak_barang;

             //mencari updatetan penerimaan setelah diinput
             $jx = $tx-$penerimaan_barang_sebelum_diubah;

             $sa = $jx + $stok_gudang->initial_stock;
             $stok_akhir=$sa;
         }else {
             $stok_akhir=$banyak_barang;
         }

        if($jenis_barang_model->formula=='1'){
            $harga_totals =round($banyak_barang*$harga_barang, -3) ;
            $harga_gudang =round($stok_akhir*$harga_barang, -3) ;
        }else{
            $harga_totals =$banyak_barang*$harga_barang;
            $harga_gudang =$stok_akhir*$harga_barang ;
        }

       // return $stok_akhir;
        $model_penerimaan->dateOfpurchase = $tanggal_penerimaan;
        $model_penerimaan->warehouse_id=$id_barang;
        $model_penerimaan->unitPrice=$harga_barang;
        $model_penerimaan->amountOfgoods=$banyak_barang;
        $model_penerimaan->suppliers_id=$supplier;
        $model_penerimaan->tbk_id=$tbk_id;
        $model_penerimaan->nomor_factur=$no_factur;
        $model_penerimaan->date_factur=$tanggal_factur;
        $model_penerimaan->totalPrice=$harga_totals;
        $model_penerimaan->status=$jenis_barang_model->formula;

        if($model_penerimaan->save()){
            $stok_gudang->initial_stock = $stok_akhir;
            $stok_gudang->total_price =$harga_gudang;
            //$stok_gudang->save();

            $mutasi_model = mutasi::where('goodreceipt_id', $idGoods)->first();

            $mutasi_model->tgl_transaksi =$tanggal_penerimaan;
            $mutasi_model->warehouse_id =$id_barang;
            $mutasi_model->goodreceipt_id =$idGoods;
            $mutasi_model->expenditures_id =0;
            $mutasi_model->jum_in =$banyak_barang;
            $mutasi_model->jum_out =0;
            $mutasi_model->remaining_stok =$stok_akhir;
            $mutasi_model->total_final =$harga_gudang;
            $mutasi_model->total =0;
            $mutasi_model->user_id =$master_id;
            $mutasi_model->save();

            $feedback = array(
                'status'=> true,
                'info'=> 'Data Penerimaan Berhasil disimpan dan menambah jumlah stok gudang'
            );

            return $feedback;
        }
    }

    public function delete($idGoods, Request $req ){

        $penerimaan_model = goodsreceipt::find($idGoods);
        $jumlah_barang_penerimaan =  $penerimaan_model->amountOfgoods;
        $gudang_model = gudang::find($penerimaan_model->warehouse_id);
        $stok_gudang = $gudang_model->initial_stock;
        $mutasI_model = mutasi::where('goodreceipt_id',$idGoods)->first();

        if($penerimaan_model->delete())
        {
            if($mutasI_model->delete()){
                $gudang_model->	initial_stock= $jumlah_barang_penerimaan;
                $gudang_model->	total_price = ($jumlah_barang_penerimaan)*$penerimaan_model->unitPrice;
                $gudang_model->save();

                $feedback = array(
                    'status'=> true,
                    'info'=> 'Data Penerimaan Berhasil dihapus dan menambah mengurangi stok gudang sesuai penerimaan yang diterima '.$idGoods
                );
                return $feedback;
            }

            $feedback = array(
                'status'=> true,
                'info'=> 'Data Penerimaan Berhasil dihapus dan gagal mengurangi stok gudang sesuai penerimaan yang diterima '
            );

            return $feedback;
        }

        $feedback = array(
            'status'=> false,
            'info'=> 'Data Tidak Bisa Dihapus'
        );
        return $feedback;

    }

    public function delete_by_jenis_barang($idTbk, Request $req ){
        $jenis_barang= $req->jenis_barang;
        $penerimaan_model = DB::table('goodreceipt')->select('goodreceipt.id')
            ->join('warehouse','warehouse.id','=','goodreceipt.warehouse_id')
            ->where('goodreceipt.tbk_id',$idTbk)
            ->where('goodreceipt.user_id', Session::get('user_id'))
            ->where('warehouse.typeofgoods_id',$jenis_barang)->get();
        foreach ($penerimaan_model as $data_barang){
            $action_ = goodsreceipt::find($data_barang->id);
            $action_pegeluaran = exspediture::all()->where('goodreceipt_id',$action_->id);
            foreach ($action_pegeluaran as $data){
                $action_peng = exspediture::find($data->id);
                if($action_peng->delete()){
                    $this->DeleteMutasimutasiPengeluaran($action_peng->id);
                }
            }
            if($action_->delete()){
                $this->DeleteMutasimutasiPenerimaan($action_->id);
            }
        }
        return redirect('goodreceipt/'.$idTbk.'/list');
    }

    public function DeleteMutasimutasiPenerimaan($id){
        $modelMutasi = DB::table('mutasi')->where('goodreceipt_id', $id);
        $kondisi = $modelMutasi->delete();
        return $kondisi;
    }
    public function DeleteMutasimutasiPengeluaran($id){
        $modelMutasi = DB::table('mutasi')->where('expenditures_id', $id);
        $kondisi = $modelMutasi->delete();
        return $kondisi;
    }

    private function property($id, $idGoods){

        if($idGoods == null){
            $models = null;
        }else{
            $models = goodsreceipt::find($idGoods);
        }
        $tahun_anggaran_aktiv = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', '1')->first();
        $pass = array(
            'goodreceipt' => goodsreceipt::where('tbk_id', $id)->where('user_id', Session::get('user_id'))->orderBy('dateOfpurchase','asc')->get(),
            'dataForm'=>$models,
            'totalharga'=>goodsreceipt::where('tbk_id', $id)->sum('totalPrice'),
            'gudang' => gudang::all()->whereIn('user_id', Session::get('user_id')),
            'supplier' => supplier::all()->whereIn('user_id', Session::get('user_id')),
            'tbk' => tbk::find($id),
            'tbkAll' => tbk::where('user_id', Session::get('user_id'))->where('number_tbk','like','%'.$tahun_anggaran_aktiv->years.'%')->get(),
            'jenis_barang' => jenis_barang::all()->where('user_id', Session::get('user_id'))
        );
        return $pass;
    }

    public function laporan_penerimaan_content(){
        $pass = array('gudang'=>
            gudang::all()->where('user_id', Session::get('user_id'))
        );
        return view('content2.page_goodreceipt.report', $pass);
    }

    public function laporan_penerimaan_content_bpk(){
        $pass = array('gudang'=>
            gudang::all()->where('user_id', Session::get('user_id'))
        );
        return view('content_pbpk.page_goodreceipt.report', $pass);
    }

    public function laporan_penerimaan_content_pemrov(){
        $pass = array('gudang'=>
            gudang::all()->where('user_id', Session::get('user_id'))
        );
        if(Session::has('id_user_inspektorat')){
            return view('content_pInspektorat.page_goodreceipt.report', $pass);
        }
    }

    public function laporan_penerimaan_content_pemkot(){
        $pass = array('gudang'=>
            gudang::all()->where('user_id', Session::get('user_id'))
        );
        if(Session::has('id_user_inspektorat')){
            return view('content_pInspektorat_pemkot.page_goodreceipt.report', $pass);
        }
    }

    public function laporan_penerimaan_content_pemkab(){
        $pass = array('gudang'=>
            gudang::all()->where('user_id', Session::get('user_id'))
        );
        return view('content_pInspektorat_pemkab.page_goodreceipt.report', $pass);
    }




    public function get_data(){
        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $data_recepit = goodsreceipt::where('user_id', Session::get('user_id'))->whereYear('dateOfpurchase', $tahun_anggaran->years)->orderBy('dateOfpurchase','ASC')->get();

        $container =array();
        $no=1;
        $jumlah_barang_keluar=0;
        foreach ($data_recepit as $row){
            $tgl_faktur ="";
            //$jumlah_barang_keluar = DB::table('expenditures')->where('goodreceipt_id', $row->id)->sum('exit_item');

            $total_keluar = 0;
            $colum = array();
            $colum[] = $no++;
            $colum[] = date('d-m-Y', strtotime($row->dateOfpurchase));
            $colum[] = "<a href='#' onclick='detail_supplier(".$row->getSupplier->id.")'>".$row->getSupplier->suppliers."</a>";
            $colum[] = $row->nomor_factur;
            if(date('d-m-Y', strtotime($row->date_factur)) !="01-01-1970"){
                $tgl_faktur = date('d-m-Y', strtotime($row->date_factur));
            }
            $colum[] =  $tgl_faktur ;
            $colum[] = $row->getGoods->goods_name.', '.$row->getGoods->specs;
            //if($jumlah_barang_keluar ==0){
                $jumlah_barang_keluar = $row->amountOfgoods;
           // }
            $colum[] = number_format($jumlah_barang_keluar,2,',','.');
            $colum[] = number_format($row->unitPrice,2,',','.');
            $colum[] = number_format($jumlah_barang_keluar*$row->unitPrice,2,',','.');
            $colum[] = '';
            $colum[] = date('d-m-Y', strtotime($row->dateOfpurchase));
            $colum[] = '';

            $container[] = $colum;
        }
        $output= array('data'=>$container);
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
        $tanggal_cetak = date('Y-m-d', strtotime($req->print_date));
        $id_barant = $req->warehouse_id1;

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $ext = $req->ext;

            if($id_barant == 0){
                $data_recepit = goodsreceipt::all()->where('dateOfpurchase','>=', $tanggal_awal)->where('dateOfpurchase','<=', $tanggal_akhir)->whereIn('user_id', Session::get('user_id'))->sortBy('dateOfpurchase');
            }else{
                $data_recepit = goodsreceipt::all()->where('warehouse_id', $id_barant)->where('dateOfpurchase','>=', $tanggal_awal)->where('dateOfpurchase','<=', $tanggal_akhir)->whereIn('user_id', Session::get('user_id'))->sortBy('dateOfpurchase');
            }
            $container =array();
            $no=1;
            $jumlah_barang_keluar=0;
            foreach ($data_recepit as $row){

                //$jumlah_barang_keluar = DB::table('expenditures')->where('goodreceipt_id', $row->id)->sum('exit_item');

                $total_keluar = 0;
                $colum = array();
                $colum[] = $no++;
                $colum[] = date('d-m-Y', strtotime($row->dateOfpurchase));
                $colum[] = $row->getSupplier->suppliers;
                $colum[] = $row->nomor_factur;
                $colum[] = date('d-m-Y', strtotime($row->date_factur));
                $colum[] = $row->getGoods->goods_name.', '.$row->getGoods->specs;
                //if($jumlah_barang_keluar ==0){
                    $jumlah_barang_keluar = $row->amountOfgoods;
               // }
                $colum[] = number_format($row->unitPrice,2,',','.');
                $colum[] = number_format($jumlah_barang_keluar,2,',','.');
                $colum[] = number_format($jumlah_barang_keluar*$row->unitPrice,2,',','.');
                $colum[] = '';
                $colum[] = date('d-m-Y', strtotime($row->dateOfpurchase));
                $colum[] = '';

                $container[] = $colum;
            }
            $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
            $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

            $output= array('data'=>$container, 'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_akhir'=>$tanggal_akhir,'tgl_cetak'=>$tanggal_cetak);

            if($ext==1){
                return view('content2.page_goodreceipt.report_receipt', $output);
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
        $tanggal_cetak = date('Y-m-d', strtotime($req->print_date));
        $id_barant = $req->warehouse_id1;

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();

        $ext = $req->ext;

        if($id_barant == 0){
            $data_recepit = goodsreceipt::all()->where('dateOfpurchase','>=', $tanggal_awal)->where('dateOfpurchase','<=', $tanggal_akhir)->whereIn('user_id', Session::get('user_id'))->sortBy('dateOfpurchase');
        }else{
            $data_recepit = goodsreceipt::all()->where('warehouse_id', $id_barant)->where('dateOfpurchase','>=', $tanggal_awal)->where('dateOfpurchase','<=', $tanggal_akhir)->whereIn('user_id', Session::get('user_id'))->sortBy('dateOfpurchase');
        }
        $container =array();
        $no=1;
        $jumlah_barang_keluar=0;
        foreach ($data_recepit as $row){

            //$jumlah_barang_keluar = DB::table('expenditures')->where('goodreceipt_id', $row->id)->sum('exit_item');

            $total_keluar = 0;
            $colum = array();
            $colum[] = $no++;
            $colum[] = date('d-m-Y', strtotime($row->dateOfpurchase));
            $colum[] = $row->getSupplier->suppliers;
            $colum[] = $row->nomor_factur;
            $colum[] = $row->date_factur;
            $colum[] = $row->getGoods->goods_name;
            if($jumlah_barang_keluar ==0){
                $jumlah_barang_keluar = $row->amountOfgoods;
            }
            $colum[] = $jumlah_barang_keluar;
            $colum[] = number_format($row->unitPrice,0,'.','.');
            $colum[] = number_format($jumlah_barang_keluar*$row->unitPrice,0,'.','.');
            $colum[] = '';
            $colum[] = date('d-m-Y', strtotime($row->dateOfpurchase));
            $colum[] = '';

            $container[] = $colum;
        }
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $output= array('data'=>$container, 'instansi'=> $instansi, 'zona'=> $wilaya, 'atasan_langsung'=> $atasan_langsung,'penyimpan_barang'=> $penyimpan_barang,'tgl_cetak'=>$tanggal_cetak);

        if($ext==1){
            return view('content2.page_goodreceipt.report_receipt', $output);
        }else if($ext==2){
            return response()->json($output);
        }else if($ext==3){
            return response()->json($output);
        }
    }

    public function laporan_perjenis_barang(){

        //return response()->json($output);
        return view('content2.report.report_rekaputulasi_perjenis_barang_content', $this->data_perjenis_barang());
    }

    public function laporan_perjenis_barang_inspektorat(){
        //return response()->json($output);
        return view('content_pInspektorat.report.report_rekaputulasi_perjenis_barang_content', $this->data_perjenis_barang());
    }


    public function laporan_perjenis_barang_bpk(){
        //return response()->json($output);
        return view('content_pbpk.report.report_rekaputulasi_perjenis_barang_content', $this->data_perjenis_barang());
    }

    public function laporan_perjenis_barang_inspektorat_pemkab(){
        //return response()->json($output);
        return view('content_pInspektorat_pemkab.report.report_rekaputulasi_perjenis_barang_content', $this->data_perjenis_barang());
    }

    public function laporan_perjenis_barang_inspektorat_pemkot(){
        //return response()->json($output);
        return view('content_pInspektorat_pemkot.report.report_rekaputulasi_perjenis_barang_content', $this->data_perjenis_barang());
    }

    public function data_perjenis_barang(){
        $jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        $tahun_anggaran= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', 1)->first();
        $no = 1;
        $column = array();
        foreach ($jenis_barang as $jenis){
            $row = array();

            $join_penerimaan = DB::table('goodreceipt')->select(DB::raw('SUM(goodreceipt.totalPrice) as totalPerjenis_barang'))
                ->join('warehouse','warehouse.id','=','goodreceipt.warehouse_id')
                ->join('tbk','tbk.id','=','goodreceipt.tbk_id')
                ->join('spj','spj.id','=','tbk.spj_id')
                ->where('goodreceipt.user_id', Session::get('user_id'))
                ->whereYear('goodreceipt.dateOfpurchase', $tahun_anggaran->years)
                ->where('warehouse.typeofgoods_id', $jenis->id)->first();
            $row[]=$no++;
            $row[] = $jenis->typeOfGoods;
            $row[] = $join_penerimaan->totalPerjenis_barang;
            $column[]= $row;
        }

        $total_permintaan_by_barang = DB::table('goodreceipt')->select(DB::raw('SUM(goodreceipt.totalPrice) as totalPerjenis_barang'))
            ->join('warehouse','warehouse.id','=','goodreceipt.warehouse_id')
            ->join('tbk','tbk.id','=','goodreceipt.tbk_id')
            ->join('spj','spj.id','=','tbk.spj_id')
            ->where('goodreceipt.user_id', Session::get('user_id'))
            ->whereYear('goodreceipt.dateOfpurchase', $tahun_anggaran->years)->first();
        $output = array('data'=>$column, 'total_harga_permintaan'=>$total_permintaan_by_barang);
        return $output;
    }

    public function print_perjenis_barang(Request $req){
        $this->validate($req, [
            'tanggal_cetak'=>'required'
        ]);
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();

        $data = [
            'instansi'=>$instansi,
            'data'=>$this->data_perjenis_barang(),
            'atasan_langsung'=> $atasan_langsung,
            'penyimpan_barang'=> $penyimpan_barang,
            'tgl_cetak'=> $req->tanggal_cetak
        ];
        return view('content2.report.report_rekapitulasi_per_jenis_barang',$data);
    }


//    public function data_perjenis_barang_berita_acara(){
//        $jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
//        $tahun_anggaran= tahun_anggaran::where('user_id', Session::get('user_id'))->where('status', 1)->first();
//        $no = 1;
//        $column = array();
//        $total_stok_opename =0;
//        foreach ($jenis_barang as $jenis){
//            $row = array();
//            $penerimaan_barang = DB::table('goodreceipt')
//                ->select('warehouse.id')
//                ->join('warehouse','warehouse.id','=','goodreceipt.warehouse_id')
//                ->where('warehouse.typeofgoods_id',$jenis->id)
//                ->whereYear('goodreceipt.dateOfpurchase',$tahun_anggaran->years)
//                ->where('warehouse.user_id',Session::get('user_id'))
//                ->groupBy('goodreceipt.warehouse_id')->get();
//            $total_jenis_barang=0;
//            foreach ($penerimaan_barang as $penerimaan){
//
//                    $cek_stok = DB::table('stock_goods')
//                        ->select("stock","harga_satuan_stok")
//                        ->where('warehouse_id',$penerimaan->id)
//                        ->first();
//
//                   $data_penerimaan_by = DB::table('goodreceipt')
//                       ->select(DB::raw('SUM(amountOfgoods) as total_penerimaan'),'goodreceipt.unitPrice')
//                       ->where('goodreceipt.warehouse_id',$penerimaan->id)
//                       ->whereYear('goodreceipt.dateOfpurchase',$tahun_anggaran->years)
//                       ->first();
//                   $data_pengeluaran_by = DB::table('expenditures')
//                        ->select(DB::raw('SUM(exit_item) as total_pengeluaran'))
//                        ->where('expenditures.warehouse_id',$penerimaan->id)
//                        ->whereYear('expenditures.out_date',$tahun_anggaran->years)
//                        ->first();
//
//                   if(!empty($cek_stok->stock)){
//                       $stok = $cek_stok->stock;
//                   }else{
//                       $stok = 0;
//                   }
//
//                   $hasilAkhir  = ($stok + $data_penerimaan_by->total_penerimaan)-$data_pengeluaran_by->total_pengeluaran;
//
//                  $total_jenis_barang+=$hasilAkhir*$data_penerimaan_by->unitPrice;
//            }
//
//            $row[]=$no++;
//            $row[] = $jenis->typeOfGoods;
//            $row[] = $total_jenis_barang;
//            $total_stok_opename +=$total_jenis_barang;
//            $column[]= $row;
//        }
//
//        $output = array('data'=>$column,'jumlah_total_stok_opname'=>$total_stok_opename);
//        return $output;
//    }
//
    public function data_perjenis_barang_berita_acara(){
        $tahun_anggaran = Tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $jenis_barang = jenis_barang::all()->where('user_id', Session::get('user_id'));
        $container =array();
        $container_cek =array();
        $jumlah_seluruh=0;
        $no=1;
        foreach ($jenis_barang as $jenis_barang){
            $row = [];
            $penerimaan_gundang = gudang::all()->where('user_id', Session::get('user_id'))->where('typeofgoods_id', $jenis_barang->id);
            $total_uang = 0;

            foreach ($penerimaan_gundang as $data){
                foreach ($data->goodMannyReceipt as $id_goodReceip=> $datas){
                    $container_cek[] = $datas;
                    $total_pengeluaran = 0;
                    if(!empty($datas->getExpendures)){
                        $total_pengeluaran = $datas->getExpendures->sum('exit_item');
                    }
                    $data_pengeluaran = $total_pengeluaran;
                    $jumlah_uang = $datas->unitPrice*($datas->amountOfgoods-$data_pengeluaran);
                    $total_uang+=$jumlah_uang;
                }
            }

            $row[]= $no++ ;
            $row[]= $jenis_barang->typeOfGoods;
            $jumlah_seluruh+=$total_uang;
            $row[]= $total_uang;
            $container[]= $row;
        }


        $output = array('data'=>$container,'jumlah_total_stok_opname'=>$jumlah_seluruh);
        return $output;
    }

    public function laporan_berita_acara_pemeriksaan(){
        return view('content2.report.report_berita_acara_pemeriksaan', $this->data_perjenis_barang_berita_acara());
    }

    public function laporan_berita_acara_pemeriksaan_inspektorat(){
        return view('content_pInspektorat.report.report_berita_acara_pemeriksaan', $this->data_perjenis_barang_berita_acara());
    }

    public function laporan_berita_acara_pemeriksaan_bpk(){
        return view('content_pbpk.report.report_berita_acara_pemeriksaan', $this->data_perjenis_barang_berita_acara());
    }

    public function laporan_berita_acara_pemeriksaan_inspektorat_pemkab(){
        return view('content_pInspektorat_pemkab.report.report_berita_acara_pemeriksaan', $this->data_perjenis_barang_berita_acara());
    }

    public function laporan_berita_acara_pemeriksaan_inspektorat_pemkot(){
        return view('content_pInspektorat_pemkot.report.report_berita_acara_pemeriksaan', $this->data_perjenis_barang_berita_acara());
    }
    public function print_berita_acara_pemeriksaan(Request $req){
        $this->validate($req, [
            'tanggal_cetak'=>'required',
            'nomor_berita_acara'=> 'required'
        ]);
        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $pengurus_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','9')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();
        $kepala_dinas = berwanang::where('user_id', Session::get('user_id'))->where('level','7')->first();

        $data = [
            'instansi'=>$instansi,
            'data'=>$this->data_perjenis_barang_berita_acara(),
            'pengurus_barang'=> $pengurus_barang,
            'penyimpan_barang'=> $penyimpan_barang,
            'kepala_dinas'=> $kepala_dinas,
            'nomor_berita_acara'=> $req->nomor_berita_acara,
            'tgl_cetak'=> $this->tanggal($req->tanggal_cetak)
        ];
        return view('content2.report.report_print_berita_acara_pemeriksaan',$data);
    }

    public function tanggal($tanggal){
        $pecah_tanggal = explode('-', $tanggal);
        $dt = Carbon::parse($tanggal,'UTC');
        $pecah=$dt->format('l-F-Y');
        $pecah_hari = explode('-', $pecah);
        $tanggal_pecah=  date('d-m-Y', strtotime($tanggal));
        $array = [
            'hari'=> $this->translate_hari($pecah_hari[0]),
            'tahun'=>$this->terbilang($pecah_tanggal[2]),
            'bulan' =>$this->translate_bulan($pecah_hari[1]),
            'tanggal'=> $this->terbilang($pecah_tanggal[0]),
            'tahun_bil'=> $pecah_tanggal[2],
            'tanggal_bil'=>$pecah_tanggal[0],
            'tanggal_cetak'=>$tanggal_pecah
        ];
        return $array;
    }

    public function translate_hari($hari){
        if($hari=='Sunday'){
            $hari = 'Minggu';
        }elseif ($hari=='Monday'){
            $hari = 'Senin';
        }elseif ($hari=='Tuesday'){
            $hari = 'Selasa';
        }elseif ($hari=='Wednesday'){
            $hari = 'Rabu';
        }elseif ($hari=='Thursday'){
            $hari = 'Kamis';
        }elseif ($hari=='Friday'){
            $hari = 'Jumat';
        }elseif ($hari=='Saturday'){
            $hari = 'Sabtu';
        }
        return $hari;
    }
    public function translate_bulan($bulan){
        if($bulan=='January'){
            $bulan = 'Januari';
        }elseif ($bulan=='February'){
            $bulan= 'Februari';
        }elseif ($bulan=='March'){
            $bulan = 'Maret';
        }elseif ($bulan=='April'){
            $bulan = 'April';
        }elseif ($bulan=='May'){
            $bulan= 'Mei';
        }elseif ($bulan=='June'){
            $bulan= 'Juni';
        }elseif ($bulan=='July'){
            $bulan= 'Juli';
        }elseif ($bulan=='July'){
            $bulan= 'Juli';
        }elseif ($bulan=='August'){
            $bulan= 'Agustus';
        }elseif ($bulan=='September'){
            $bulan= 'September';
        }elseif ($bulan=='October'){
            $bulan= 'Oktober';
        }elseif ($bulan=='November'){
            $bulan= 'November';
        }elseif ($bulan=='December'){
            $bulan= 'Desember';
        }
        return $bulan;
    }

    public function kekata($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $temp = "";
        if ($x <12) {
            $temp = " ". $angka[$x];
        } else if ($x <20) {
            $temp = $this->kekata($x - 10). " belas";
        } else if ($x <100) {
            $temp = $this->kekata($x/10)." puluh".$this-> kekata($x % 10);
        } else if ($x <200) {
            $temp = " seratus" . $this->kekata($x - 100);
        } else if ($x <1000) {
            $temp = $this->kekata($x/100) . " ratus" . $this->kekata($x % 100);
        } else if ($x <2000) {
            $temp = " seribu" . $this->kekata($x - 1000);
        } else if ($x <1000000) {
            $temp = $this->kekata($x/1000) . " ribu" . $this->kekata($x % 1000);
        } else if ($x <1000000000) {
            $temp = $this->kekata($x/1000000) . " juta" . $this->kekata($x % 1000000);
        } else if ($x <1000000000000) {
            $temp = $this->kekata($x/1000000000) . " milyar" . $this->kekata(fmod($x,1000000000));
        } else if ($x <1000000000000000) {
            $temp = $this->kekata($x/1000000000000) . " trilyun" . $this->kekata(fmod($x,1000000000000));
        }
        return $temp;
    }


    public function terbilang($x, $style=4) {
        if($x<0) {
            $hasil = "minus ". trim($this->kekata($x));
        } else {
            $hasil = trim($this->kekata($x));
        }
        switch ($style) {
            case 1:
                $hasil = strtoupper($hasil);
                break;
            case 2:
                $hasil = strtolower($hasil);
                break;
            case 3:
                $hasil = ucwords($hasil);
                break;
            default:
                $hasil = ucfirst($hasil);
                break;
        }
        return $hasil;
    }

}
