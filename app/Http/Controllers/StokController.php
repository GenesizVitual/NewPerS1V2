<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Fiscal_years as tahun_anggaran;

use App\StockGoods as stok_barang;

use App\Warehouse as barang;

use App\Goodreceipt as goodsreceipt;

use App\Spj as spj;

use App\Tbk as tbk;

use App\Mutasi as mutasi;

use Session;

use Redirect;


use App\Goodreceipt as penerimaan_barang;

use App\Expenditures as pengeluaran_barang;



class StokController extends Controller
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
        $pass = [
            'tahun_anggaran' => tahun_anggaran::where('user_id', Session::get('user_id'))->get(),
            'tahun_anggaran_aktif' => tahun_anggaran::where('status', '1')->where('user_id', Session::get('user_id'))->first()
        ];
        return view('content2.page_stok.index', $pass);
    }

    public function getDataStock($id_tahun_anggaran)
    {
        $stokbarang = stok_barang::where('fiscal_years_id', $id_tahun_anggaran)->where('user_id', Session::get('user_id'))->get();
        $no=1;
        $column = [];

        foreach ($stokbarang as $data)
        {
            $row = [];
            $row[]= $no++;
            $row[]= date("d-m-Y", strtotime($data->tgl_akhir_catatan));
            $row[]= $data->getGoods->goods_name .' | '. $data->getGoods->specs;
            $row[]= number_format($data->harga_satuan_stok, 2,",",'.');
            $row[]= $data->stock;
            $row[]= '<a href="'.url('editStok/'.$data->id).'" class="btn btn-warning"> edit </a> <a href="'.url('deleteStok/'.$data->id).'" class="btn btn-danger""> hapus </a>';
            $column[] = $row;
        }

        $output = ['output'=> $column];
        return $output;
    }

    public function create()
    {
        $pass =[
            'tahun_anggaran'=> tahun_anggaran::where('user_id', Session::get('user_id'))->get(),
            'barang'=> barang::where('user_id', Session::get('user_id'))->get()
        ];

        return view('content2.page_stok.new', $pass);
    }

    public function store(Request $req)
    {
        $this->validate($req,[
            'barang'    => 'required',
            'tahun_anggaran' => 'required',
            'tgl_akhir_catatan' => 'required',
            'harga_satuan_stok' => 'required|numeric',
            'sisa_stok_barang' => 'required|numeric'
        ]);

        $barang = $req->barang;
        $tgl_akhir_catatan = date('Y-m-d', strtotime($req->tgl_akhir_catatan));
        $harga_satuan_stok = $req->harga_satuan_stok;
        $tahun_anggaran = $req->tahun_anggaran;
        $sisa_stok_barang = $req->sisa_stok_barang;

        $stokbarangModel = new stok_barang();
        $stokbarangModel->warehouse_id = $barang;
        $stokbarangModel->fiscal_years_id = $tahun_anggaran;
        $stokbarangModel->tgl_akhir_catatan = $tgl_akhir_catatan;
        $stokbarangModel->harga_satuan_stok = $harga_satuan_stok;
        $stokbarangModel->stock = $sisa_stok_barang;
        $stokbarangModel->user_id = Session::get('user_id');

        if($stokbarangModel->save())
        {
            $req->session()->flash('message_success', 'Stok berhasil ditambahkan');
            return redirect('stock');
        }
        $req->session()->flash('message_fail', 'Stok gagal ditambahkan');
        return redirect('insertStok');
    }


    public function import_stok(){
        $tahun_anggaran = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status','1')->first();
        $stokbarang = stok_barang::all()->where('fiscal_years_id', $tahun_anggaran->id)->where('user_id', Session::get('user_id'));

        $spj = spj::updateOrCreate(
            ['number_spj'=> 'stokSpj/'. ($tahun_anggaran->years-1)],
            ['user_id'=> Session::get('user_id')]
        );
        if($spj){
            $tbk = tbk::updateOrCreate(
                ['number_tbk'=> 'StokTbk/'. ($tahun_anggaran->years-1),'spj_id'=>$spj->id],
                ['user_id'=> Session::get('user_id')]
            );
            if($tbk){
                foreach ($stokbarang as $data){


                    $importToGood = goodsreceipt::updateOrCreate(
                        [ 'warehouse_id'=>$data->warehouse_id, 'tbk_id'=>$tbk->id , 'user_id'=>Session::get('user_id')],
                        [
                            'dateOfpurchase'=>$data->tgl_akhir_catatan,
                            'amountOfgoods'=>$data->stock,
                            'unitPrice'=>$data->harga_satuan_stok,
                            'totalPrice'=>$data->stock*$data->harga_satuan_stok,
                            'status'=>0,
                            'suppliers_id'=>1,
                        ]
                    );

                    if($importToGood){
                        $mutasi = mutasi::updateOrCreate(
                            [
                                'warehouse_id' => $data->warehouse_id,
                                'goodreceipt_id'=>$importToGood->id,
                                'user_id'=> Session::get('user_id')
                            ],
                            [
                            'tgl_transaksi' =>$data->tgl_akhir_catatan,
                            'expenditures_id'=>0,
                            'last_stock' =>0,
                            'jum_in'=>$data->stock,
                            'jum_out'=>0,
                            'remaining_stok'=>$data->stock,
                            'total_start'=>0,
                            'total_final'=>0,
                            'total'=>0,
                            ]);
                        $mutasi->save();
                    }

                }
            }
        }
        return redirect('stock')->with('message','Stok Awal Berhasil diimport');
    }

    public function import_stok_tahun_ke_tahun_mendatang()
    {
        $tahun_anggaran_model = tahun_anggaran::where('status','1')->where('user_id', Session::get('user_id'))->first();
        if(!empty($tahun_anggaran_model->years)){
            $ambil_data_barang = barang::all()->where('user_id', '7');

            $no=1;
            $colum=[];
            foreach ($ambil_data_barang as $key => $value)
            {
                $stok_barang = stok_barang::where('warehouse_id', $value->id)->where('fiscal_years_id', $tahun_anggaran_model->id)->first();
                if(!empty($stok_barang->stock)){
                    $harga_satuans=$stok_barang->stock;
                }else{
                    $harga_satuans=0;
                }

                $data_penerimaan = penerimaan_barang::where('warehouse_id', $value->id)->orderBy('dateOfpurchase', 'desc')->first();

                $ambil_data_penerimaan =  penerimaan_barang::where('warehouse_id', $value->id)->whereYear('dateOfpurchase',$tahun_anggaran_model->years)->where('user_id', Session::get('user_id'))->orderBy('id','desc')->sum('amountOfgoods');
                $ambil_data_pengerluaran =  pengeluaran_barang::where('warehouse_id', $value->id)->whereYear('out_date',$tahun_anggaran_model->years)->where('user_id', Session::get('user_id'))->sum('exit_item');
                $stok_barang = $harga_satuans+$ambil_data_penerimaan-$ambil_data_pengerluaran;

                $tahun_anggaran = tahun_anggaran::firstOrCreate(['years' => $tahun_anggaran_model->years+1,'user_id'=>Session::get('user_id')]);

                if($stok_barang>0) {
                    if($tahun_anggaran){

                        $stok_barang_update = stok_barang::updateOrCreate(
                            ['warehouse_id'=>$data_penerimaan->warehouse_id,'fiscal_years_id'=>$tahun_anggaran->id,'user_id'=>Session::get('user_id')],
                            ['tgl_akhir_catatan'=>$data_penerimaan->dateOfpurchase,'stock'=>$stok_barang,'harga_satuan_stok'=>$data_penerimaan->unitPrice]
                        )->save();
                    }
                }

            }
            return redirect('stock')->with('message','Data Stok Tahun Ini telah diimport ke tahun berikutnya');
        }else{
            return redirect('stock')->with('message','Gagal Import stok barang, periksa tahun yang aktif sekarang');
        }
    }


    public function edit($id)
    {
        $pass =[
            'object'=> stok_barang::find($id),
            'tahun_anggaran'=> tahun_anggaran::where('user_id', Session::get('user_id'))->get(),
            'barang'=> barang::where('user_id', Session::get('user_id'))->get()
        ];
        return view('content2.page_stok.edit', $pass);
    }

    public function update(Request $req, $id)
    {
        $this->validate($req,[
            'barang'    => 'required',
            'tahun_anggaran' => 'required',
            'tgl_akhir_catatan' => 'required',
            'harga_satuan_stok' => 'required|numeric',
            'sisa_stok_barang' => 'required|numeric'
        ]);

        $barang = $req->barang;
        $tgl_akhir_catatan =date('Y-m-d', strtotime($req->tgl_akhir_catatan));
        $harga_satuan_stok = $req->harga_satuan_stok;
        $tahun_anggaran = $req->tahun_anggaran;
        $sisa_stok_barang = $req->sisa_stok_barang;

        $stokbarangModel = stok_barang::find($id);
        $stokbarangModel->warehouse_id = $barang;
        $stokbarangModel->fiscal_years_id = $tahun_anggaran;
        $stokbarangModel->tgl_akhir_catatan = $tgl_akhir_catatan;
        $stokbarangModel->harga_satuan_stok = $harga_satuan_stok;
        $stokbarangModel->stock = $sisa_stok_barang;
        $stokbarangModel->user_id = Session::get('user_id');

        if($stokbarangModel->save())
        {
            $req->session()->flash('message_success', 'Stok berhasil diubah');
            return redirect('stock');
        }

        $req->session()->flash('message_fail', 'Stok gagal diubah');
        return redirect('editStok'.$id);
    }

    public function delete($id)
    {
         $stokbarangModel = stok_barang::find($id);
        if($stokbarangModel->delete())
        {
            Session::flash('message_success', 'Stok berhasil dihapus');
            return redirect('stock');
        }

        Session::flash('message_fail', 'Stok gagal dihapus');
        return redirect('stock');
    }
}
