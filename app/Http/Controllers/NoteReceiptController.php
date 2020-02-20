<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use App\NoteBeritaAcaraSerahTerimaPekerjaan;
use Illuminate\Http\Request;

use App\Suppliers as suppliers;

use App\Authorized as berwenang;

use Session;

use App\Note_receipt as nota_pesanan;

use App\Belanja as belanja;

use App\Instance as instansi;

use App\Warehouse as gudang;

use App\Rincian_barang_model as rincian_barang;

use App\Note_berita_acara_HP as berita_acara_hasil_penerimaan;

use App\Note_berita_acara as berita_acara;

use App\Fiscal_years as tahun_anggaran;

use App\NoteBeritaAcaraSerahTerimaPekerjaan as serah_terima_pekerjaan;

use App\Spj as spj;

use Carbon\Carbon;

class NoteReceiptController extends Controller
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



    //======================================= Surat Pesanan ==========================================================
    public function index(){
        $data_nota = nota_pesanan::where('user_id', Session::get('user_id'))->orderBy('created_at', 'asc')->get();
        return view('content2.note_receipt.index', array('data_nota'=> $data_nota));
    }

    public function create()
    {
        $berwenang = berwenang::all()->where('user_id', Session::get('user_id'))->where('level',6);
        $suppliers = suppliers::all()->where('user_id', Session::get('user_id'));
        $belanja = belanja::all()->where('user_id', Session::get('user_id'));
        $pass = [
            'berwenang'=> $berwenang,
            'suppliers'=> $suppliers,
            'belanja'=> $belanja
        ];
        return view('content2.note_receipt.new', $pass);
    }

    public function store(Request $req){

        $this->validate($req, [
           'no_surat_pesanan'=>'required',
           'belanja_id'=>'required',
            'pengguna_anggaran'=>'required',
            'suppliers_id'=>'required',
           'tanggal_selesai_pekerjaan'=> 'required',
           'syarat_syarat_pekerjaan'=> 'required',
           'tgl_awal_pekerjaan'=> 'required'
        ]);
         $belanja_id = $req->belanja_id;
        $pengguna_anggaran = $req->pengguna_anggaran;
        $suppliers = $req->suppliers_id;
        $tanggal_selesai_pekerjaan = $req->tanggal_selesai_pekerjaan;
        $syarat_syarat_pekerjaan = $req->syarat_syarat_pekerjaan;
        $tgl_awal_pekerjaan = $req->tgl_awal_pekerjaan;

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $model = new nota_pesanan();
        $model->nomor_surat = $req->no_surat_pesanan;
        $model->belanja_id = $belanja_id;
        $model->supplier_id = $suppliers;
        $model->pengguna_anggaran = $pengguna_anggaran;
        $model->tanggal_selesai_pekerjaan = date('Y-m-d', strtotime($tanggal_selesai_pekerjaan));
        $model->syarat_syarat_pekerjaan = $syarat_syarat_pekerjaan;
        $model->tgl_awal_pekerjaan = date('Y-m-d', strtotime($tgl_awal_pekerjaan));
        $model->instansi_id = $instansi->id;
        $model->user_id = Session::get('user_id');

        if($model->save()){
            $req->session()->flash('message_success','Anda berhasil membuat nota pesanan');
            return redirect('nota_p');
        }

        $req->session()->flash('message_fail','Anda gagal membuat nota pesanan');
        return redirect('buat_nota');

    }

    public function edit($id)
    {
        $berwenang = berwenang::all()->where('user_id', Session::get('user_id'))->where('level',6);
        $suppliers = suppliers::all()->where('user_id', Session::get('user_id'));
        $belanja = belanja::all()->where('user_id', Session::get('user_id'));
        $nota = nota_pesanan::find($id);
        $pass = [
            'berwenang'=> $berwenang,
            'suppliers'=> $suppliers,
            'belanja'=> $belanja,
            'nota'=> $nota
        ];
        return view('content2.note_receipt.edit', $pass);
    }

    public function update(Request $req, $id){
        $this->validate($req, [
            'no_surat_pesanan'=>'required',
            'belanja_id'=>'required',
            'pengguna_anggaran'=>'required',
            'suppliers_id'=>'required',
            'tanggal_selesai_pekerjaan'=> 'required',
            'syarat_syarat_pekerjaan'=> 'required',
            'tgl_awal_pekerjaan'=> 'required'
        ]);

        $belanja_id = $req->belanja_id;
        $pengguna_anggaran = $req->pengguna_anggaran;
        $suppliers = $req->suppliers_id;
        $tanggal_selesai_pekerjaan = $req->tanggal_selesai_pekerjaan;
        $syarat_syarat_pekerjaan = $req->syarat_syarat_pekerjaan;
        $tgl_awal_pekerjaan = $req->tgl_awal_pekerjaan;

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $model = nota_pesanan::find($id);
        $model->nomor_surat = $req->no_surat_pesanan;
        $model->belanja_id = $belanja_id;
        $model->supplier_id = $suppliers;
        $model->pengguna_anggaran = $pengguna_anggaran;
        $model->tanggal_selesai_pekerjaan = date('Y-m-d', strtotime($tanggal_selesai_pekerjaan));
        $model->syarat_syarat_pekerjaan = $syarat_syarat_pekerjaan;
        $model->tgl_awal_pekerjaan = date('Y-m-d', strtotime($tgl_awal_pekerjaan));
        $model->instansi_id = $instansi->id;
        $model->user_id = Session::get('user_id');

        if($model->save()){
            $req->session()->flash('message_success','Anda berhasil mengubah nota pesanan');
            return redirect('nota_p');
        }

        $req->session()->flash('message_fail','Anda gagal mengubah nota pesanan');
        return redirect('nota_p/'.$id.'/edit');
    }

    public function delete(Request $req,$id){
        $model = nota_pesanan::find($id);
        if($model->delete()) {
            $req->session()->flash('message_success', 'Anda berhasil menghapus nota pesanan');
            return redirect('nota_p');
        }

        $req->session()->flash('message_fail','Anda gagal menghapus nota pesanan');
        return redirect('nota_p');
    }

    public function report_rincian_surat($id){
        $nota_pesanan = nota_pesanan::find($id);
        $insansi = instansi::where('user_id', Session::get('user_id'))->first();
        $pass = [
            'nota_pesanan'=> $nota_pesanan,
            'instansi'=> $insansi
        ];
        return view('content2.report.report_note_pesanan', $pass);
    }

//=================================== Rincian Barang ==================================================================
    public function rincian_surat($id){
        $nota_pesanan = nota_pesanan::find($id);
        $barang = gudang::all()->where('user_id', Session::get('user_id'));
        $pass = [
            'nota_pesanan'=> $nota_pesanan,
            'barang'=> $barang,
            'barang2'=> $barang,
        ];
        return view('content2.note_receipt.rincian_barang.index', $pass);
    }

    public function rincian_barang($id){
        $data = rincian_barang::all()->where('user_id', Session::get('user_id'))->where('id_nota', $id);
        $column = array();
        $no=1;
        $id_rincian_barang=array();
        foreach ($data as $data){
            $row = array();
            $row[] = $no++;
            $row[] = $data->get_barang->goods_name;
            $row[] = $data->quntitas;
            $row[] = $data->satuan;
            $row[] = number_format($data->harga_satuan, 2,'.',',');
            $row[] = number_format($data->quntitas*$data->harga_satuan, 2,'.',',');
            $row[] = '<button class="btn btn-warning"  style="padding-bottom=10px" onclick="edit('.$data->id.')">ubah</button>'.'<button class="btn btn-danger" onclick="deletes('.$data->id.')">hapus</button>';
            $id_rincian_barang[] = $data->id;
            $column[] = $row;
        }
        $jumlah_harga_rincian_barang = rincian_barang::where('id_nota',$id)->sum('jumlah_harga');
        $output = array('data'=>$column,'jumlah_harga'=>number_format($jumlah_harga_rincian_barang,2,'.',','), 'terbilang'=> $this->terbilang($jumlah_harga_rincian_barang)." Rupiah",
            'id_rincian_barang'=> implode(",", $id_rincian_barang));
        return response()->json($output);
    }

    public function cek_belanja($id_belanja, $uang_tambahan){
        $model_nota_pesanan= nota_pesanan::where('belanja_id', $id_belanja)->where('user_id', Session::get('user_id'))->get();
        $maks_belanja = belanja::find($id_belanja);
        $jumlah_total_pesanan = 0;
        foreach ($model_nota_pesanan as $rin){
            $hitung_jumlah_barang_barang_pernota = rincian_barang::where('id_nota', $rin->id)->sum('jumlah_harga');
            $jumlah_total_pesanan+=$hitung_jumlah_barang_barang_pernota;
        }

        if($jumlah_total_pesanan+$uang_tambahan <= $maks_belanja->total_price ){
            $feetback = [
                'pesan'=> 'Sisa Uang Belanja Pada belanja ini adalah :'. ($maks_belanja->total_price+$uang_tambahan-$jumlah_total_pesanan),
                'status' => true,
                'sisa_uang'=>number_format(($maks_belanja->total_price-$jumlah_total_pesanan), 2,'.',',')
            ];
        }else{
            $feetback = [
                'pesan'=> 'Sisa Uang Belanja Pada belanja ini adalah :'. ($maks_belanja->total_price+$uang_tambahan-$jumlah_total_pesanan),
                'status' => false,
                'sisa_uang' => number_format(($maks_belanja->total_price-$jumlah_total_pesanan), 2,'.',',')
            ];
        }

        return $feetback;
    }

    public function getSisaJumlah_belanja($id_belanja){
        return response()->json($this->cek_belanja($id_belanja, 0));
    }

    public function store_rincian_barang(Request $req){
        $this->validate($req,[
            'id_nota'=> 'required',
            'id_belanja'=> 'required',
            'barang'=> 'required',
            'quantitas'=> 'required',
            'satuan' => 'required',
            'harga_satuan' => 'required',
            '_token'=> 'required'
        ]);

        $id_nota = $req->id_nota;
        $barang = $req->barang;
        $id_belanja = $req->id_belanja;
        $quantitas = $req->quantitas;
        $satuan = $req->satuan;
        $harga_satuan = $req->harga_satuan;
        $jumlah_barang = $quantitas* $harga_satuan;

        $model = new rincian_barang();
        $model->id_nota = $id_nota;
        $model->id_barang = $barang;
        $model->quntitas=$quantitas;
        $model->satuan=$satuan;
        $model->harga_satuan=$harga_satuan;
        $model->jumlah_harga= $jumlah_barang;
        $model->user_id= Session::get('user_id');

        if($this->cek_belanja($id_belanja, $jumlah_barang)['status']==false){
            $feetback = [
                'pesan'=> 'Total Jumlah rincian melebihi jumlah Uang Belanja',
                'status'=> false
            ];
            return response()->json($feetback);
        }

        if($model->save()){
            $feetback = [
                'pesan'=> 'Barang berhasil ditambahkan',
                'status'=> true
            ];
            return response()->json($feetback);
        }

        $feetback = [
            'pesan'=> 'Barang gagal ditambahkan',
            'status'=> false
        ];
        return response()->json($feetback);
    }

    public function edit_rincian_barang($id){
        $data = rincian_barang::find($id);
        return response()->json($data);
    }

    public function update_rincian_barang(Request $req, $id){
        $this->validate($req,[
            'id_nota'=> 'required',
            'id_belanja'=> 'required',
            'barang'=> 'required',
            'quantitas'=> 'required',
            'satuan' => 'required',
            'harga_satuan' => 'required',
            '_token'=> 'required'
        ]);

        $id_nota = $req->id_nota;
        $barang = $req->barang;
        $id_belanja = $req->id_belanja;
        $quantitas = $req->quantitas;
        $satuan = $req->satuan;
        $harga_satuan = $req->harga_satuan;
        $jumlah_barang = $quantitas* $harga_satuan;

        $model = rincian_barang::find($id);
        $model->id_nota = $id_nota;
        $model->id_barang = $barang;
        $model->quntitas=$quantitas;
        $model->satuan=$satuan;
        $model->harga_satuan=$harga_satuan;
        $model->jumlah_harga= $jumlah_barang;
        $model->user_id= Session::get('user_id');

        if($this->cek_belanja($id_belanja,$jumlah_barang)['status']==false){
            $feetback = [
                'pesan'=> 'Total Jumlah rincian melebihi jumlah Uang Belanja',
                'status'=> false
            ];
            return response()->json($feetback);
        }

        if($model->save()){
            $feetback = [
                'pesan'=> 'Barang berhasil diubah',
                'status'=> true
            ];
            return response()->json($feetback);
        }

        $feetback = [
            'pesan'=> 'Barang gagal diubah',
            'status'=> false
        ];
        return response()->json($feetback);
    }

    public function delete_rincian_barang($id){

        $model = rincian_barang::find($id);
        if($model->delete()){
            $feetback = [
                'pesan'=> 'Barang berhasil diubah',
                'status'=> true
            ];
            return response()->json($feetback);
        }

        $feetback = [
            'pesan'=> 'Barang gagal diubah',
            'status'=> false
        ];
        return response()->json($feetback);
    }

    //==================================================================================================================



    //========================== Berita Acara penerimaan hasil pekerjaan pengadaan barang ==============================

    public function daftar_berita_acara_penerimaan_hasil_pekerjaan()
    {
        $model_berita_acara = berita_acara_hasil_penerimaan::all()->where('user_id', Session::get('user_id'))->sortByDesc('tgl_berita_acara');
        $data=[
            'data_nota'=> $model_berita_acara
        ];
        return view('content2.note_hasil_pekerjaan.index', $data);
    }

    public function create_berita_acara_Hp(){
        $model_surat_pesanan= nota_pesanan::all()->where('user_id', Session::get('user_id'));
        $data = [
            'data_surat_pesanan' => $model_surat_pesanan
        ];
        return view('content2.note_hasil_pekerjaan.new', $data);
    }


    public function store_berita_acara_hp(Request $req){
        $this->validate($req,[
            'nota_id'=> 'required',
            'no_berita_acara'=> 'required',
            'no_keputusan'=> 'required',
            'tgl_berita_acara'=> 'required',
            'tgl_surat_keputusan'=> 'required'
        ]);

        $nota_id = $req->nota_id;
        $no_berita_acara = $req->no_berita_acara;
        $no_keputusan= $req->no_keputusan;
        $tgl_berita_acara = date('Y-m-d',strtotime($req->tgl_berita_acara));
        $tgl_surat_keputusan = date('Y-m-d',strtotime($req->tgl_surat_keputusan));

        $model_berita_acara = new berita_acara_hasil_penerimaan();
        $model_berita_acara->id_nota = $nota_id;
        $model_berita_acara->no_keputusan = $no_keputusan;
        $model_berita_acara->nomor_berita_acara = $no_berita_acara;
        $model_berita_acara->tanggal_berita_acara = $tgl_berita_acara;
        $model_berita_acara->tgl_surat_keputusan = $tgl_surat_keputusan;
        $model_berita_acara->user_id = Session::get('user_id');

        if($model_berita_acara->save()){
            $req->session()->flash('message_success','Surat Berita Acara Hasil Penerimaan Berhasil dibuat denga no:'. $no_berita_acara);
            return redirect('daftar_berita_acara_penerimaan_hasil_pekerjaan');
        }

        $req->session()->flash('message_fail','Gagal membuat surat berita acara penerimaan hasil pekerjaan');
        return redirect('tambah_berita_acara_hasil_pekerjaan');
    }


    public function edit_berita_acara_Hp($id){
        $model_surat_pesanan= nota_pesanan::all()->where('user_id', Session::get('user_id'));
        $model_berita_acara = berita_acara_hasil_penerimaan::find($id);
        $data = [
            'data_surat_pesanan' => $model_surat_pesanan,
            'nota' => $model_berita_acara
        ];
        return view('content2.note_hasil_pekerjaan.edit', $data);
    }

    public function update_berita_acara_Hp(Request $req, $id){
        $this->validate($req,[
            'nota_id'=> 'required',
            'no_berita_acara'=> 'required',
            'no_keputusan'=> 'required',
            'tgl_berita_acara'=> 'required',
            'tgl_surat_keputusan'=> 'required'
        ]);

        $nota_id = $req->nota_id;
        $no_berita_acara = $req->no_berita_acara;
        $no_keputusan = $req->no_keputusan;
        $tgl_berita_acara = date('Y-m-d',strtotime($req->tgl_berita_acara));
        $tgl_surat_keputusan = date('Y-m-d',strtotime($req->tgl_surat_keputusan));

        $model_berita_acara = berita_acara_hasil_penerimaan::find($id);
        $model_berita_acara->id_nota = $nota_id;
        $model_berita_acara->no_keputusan = $no_keputusan;
        $model_berita_acara->nomor_berita_acara = $no_berita_acara;
        $model_berita_acara->tanggal_berita_acara = $tgl_berita_acara;
        $model_berita_acara->tgl_surat_keputusan = $tgl_surat_keputusan;
        $model_berita_acara->user_id = Session::get('user_id');

        if($model_berita_acara->save()){
            $req->session()->flash('message_success','Surat Berita Acara Hasil Penerimaan Berhasil diubah dengan no:'. $no_berita_acara);
            return redirect('daftar_berita_acara_penerimaan_hasil_pekerjaan');
        }

        $req->session()->flash('message_fail','Gagal mengubah surat berita acara penerimaan hasil pekerjaan');
        return redirect('nota_BPH/'.$id.'/edit');
    }


    public function delete_berita_acara_Hp(Request $req, $id){
        $model_berita_acara = berita_acara_hasil_penerimaan::find($id);
        if($model_berita_acara->delete()){
            $req->session()->flash('message_success','Surat Berita Acara Hasil Penerimaan Berhasil dihapush');
            return redirect('daftar_berita_acara_penerimaan_hasil_pekerjaan');
        }
        $req->session()->flash('message_fail','Gagal mengubah surat berita acara penerimaan hasil pekerjaan');
        return redirect('daftar_berita_acara_penerimaan_hasil_pekerjaan');
    }

    public function detail_berita_acara_hp($id){
        $model_berita_acaa_hp = berita_acara_hasil_penerimaan::find($id);
        $model_instansi=instansi::where('user_id', Session::get('user_id'))->first();
        $model_fiscal_years = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status',1)->first();
        $model = [
            'berita_acara'=>$model_berita_acaa_hp,
            'tanggal'=>$this->tanggal($model_berita_acaa_hp->tanggal_berita_acara),
            'tanggal_nota'=> $this->tanggal($model_berita_acaa_hp->tgl_surat_keputusan),
            'instansi'=> $model_instansi,
            'tahun_anggaran' => $model_fiscal_years
        ];
        return view('content2.note_hasil_pekerjaan.rincian_barang.index', $model);
    }

    public function print_detail_berita_acara_hp($id){
        $model_berita_acaa_hp = berita_acara_hasil_penerimaan::find($id);
        $model_instansi=instansi::where('user_id', Session::get('user_id'))->first();
        $model_fiscal_years = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status',1)->first();
        $model = [
            'berita_acara'=>$model_berita_acaa_hp,
            'tanggal'=>$this->tanggal($model_berita_acaa_hp->tanggal_berita_acara),
            'tanggal_nota'=> $this->tanggal($model_berita_acaa_hp->tgl_surat_keputusan),
            'instansi'=> $model_instansi,
            'tahun_anggaran' => $model_fiscal_years
        ];
        return view('content2.report.report_note_berita_acara_penerimaan_hasil_pekerjaan', $model);
    }

//======================================================================================================================

//========================== Berita Acara penerimaan barang/jasa =======================================================

    public function daftar_berita_acara_penerimaan_barang(){
        $model_berita_acara = berita_acara::all()->where('user_id', Session::get('user_id'))->sortByDesc('tgl_berita_acara');
        $data = [
            'data_nota'=> $model_berita_acara,
        ];
        return view('content2.note_berita_acara_penerimaan.index', $data);
    }

    public function create_berita_acara_penerimaan_barang(){
        $model_berita_acara_ph = berita_acara_hasil_penerimaan::all()->where('user_id', Session::get('user_id'));
        $data_pass = [
            'data_surat_hasil_penerimaan'=> $model_berita_acara_ph
        ];
        return view('content2.note_berita_acara_penerimaan.new', $data_pass);
    }


    public function store_berita_acara_penerimaan_barang(Request $req){
        $this->validate($req,[
           'id_berita_acara_HP' => 'required',
            'nomor_berita_acara'=> 'required',
            'nomor_surat_keputusan'=> 'required',
            'tgl_berita_acara'=>'required',
            'tgl_surat_keputusan'=>'required'
        ]);

        $id_berita_cara_hp = $req->id_berita_acara_HP;
        $nomor_berita_acara = $req->nomor_berita_acara;
        $nomor_surat_keputusan = $req->nomor_surat_keputusan;
        $tgl_berita_acara = date('Y-m-d', strtotime($req->tgl_berita_acara));
        $tgl_surat_keputusan = date('Y-m-d', strtotime($req->tgl_surat_keputusan));

        $model = new berita_acara();
        $model->id_berita_acara_HP = $id_berita_cara_hp;
        $model->nomor_berita_acara = $nomor_berita_acara;
        $model->nomor_surat_keputusan = $nomor_surat_keputusan;
        $model->tgl_berita_acara = $tgl_berita_acara;
        $model->tgl_surat_keputusan = $tgl_surat_keputusan;
        $model->user_id= Session::get('user_id');

        if($model->save()){
            $req->session()->flash('message_success','Surat Berita Acara Penerimaan Barang Berhasil dibuat dengan no:'. $nomor_berita_acara);
            return redirect('berita_acara_penerimaan_barang_jasa');
        }

        $req->session()->flash('message_fail','Gagal membuat surat berita acara penerimaan brang');
        return redirect('tambah_berita_acara_penerimaan_barang_jasa');
    }

    public function edit_berita_acara_penerimaan_barang($id){
        $model_berita_acara_ph = berita_acara_hasil_penerimaan::all()->where('user_id', Session::get('user_id'));
        $model_berita_acara = berita_acara::find($id);
        $data_pass = [
            'data_surat_hasil_penerimaan'=> $model_berita_acara_ph,
            'data'=>$model_berita_acara
        ];
        return view('content2.note_berita_acara_penerimaan.edit', $data_pass);
    }

    public function update_berita_acara_penerimaan_barang(Request $req, $id){
        $this->validate($req,[
            'id_berita_acara_HP' => 'required',
            'nomor_berita_acara'=> 'required',
            'nomor_surat_keputusan'=> 'required',
            'tgl_berita_acara'=>'required',
            'tgl_surat_keputusan'=>'required'
        ]);

        $id_berita_cara_hp = $req->id_berita_acara_HP;
        $nomor_berita_acara = $req->nomor_berita_acara;
        $nomor_surat_keputusan = $req->nomor_surat_keputusan;
        $tgl_berita_acara = date('Y-m-d', strtotime($req->tgl_berita_acara));
        $tgl_surat_keputusan = date('Y-m-d', strtotime($req->tgl_surat_keputusan));

        $model = berita_acara::find($id);
        $model->id_berita_acara_HP = $id_berita_cara_hp;
        $model->nomor_berita_acara = $nomor_berita_acara;
        $model->nomor_surat_keputusan = $nomor_surat_keputusan;
        $model->tgl_berita_acara = $tgl_berita_acara;
        $model->tgl_surat_keputusan= $tgl_surat_keputusan;
        $model->user_id= Session::get('user_id');

        if($model->save()){
            $req->session()->flash('message_success','Surat Berita Acara Penerimaan Barang Berhasil mengubah dengan no:'. $nomor_berita_acara);
            return redirect('berita_acara_penerimaan_barang_jasa');
        }

        $req->session()->flash('message_fail','Gagal mengubah surat berita acara penerimaan brang');
        return redirect('tambah_berita_acara_penerimaan_barang_jasa');
    }

    public function delete_berita_acara_penerimaan_barang(Request $req, $id){
        $model = berita_acara::find($id);
        if($model->delete()){
            $req->session()->flash('message_success','Surat Berita Acara Penerimaan Barang Berhasil mengubah dihapus');
            return redirect('berita_acara_penerimaan_barang_jasa');
        }
        $req->session()->flash('message_fail','Gagal menghapus surat berita acara penerimaan barang');
        return redirect('tambah_berita_acara_penerimaan_barang_jasa');
    }

    public function detail_surat_berita_acara_penerimaan($id){
        $model = berita_acara::find($id);
        $berwenang =berwenang::where('level', 5)->where('user_id', Session::get('user_id'))->first();
        $instance =instansi::where('user_id', Session::get('user_id'))->first();
        $tahun_anggaran = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status',1)->first();
        $spj= spj::all()->where('user_id', Session::get('user_id'));
        $data=[
            'berita_acara'=> $model,
            'tanggal'=>$this->tanggal($model->tgl_berita_acara),
            'tanggal_surat_keputusan'=>$this->tanggal($model->tgl_surat_keputusan),
            'tahun_anggaran'=> $tahun_anggaran,
            'berwenang' => $berwenang,
            'instansi' => $instance,
            'spj' => $spj
        ];
        return view('content2.note_berita_acara_penerimaan.rincian_barang.index', $data);
    }

    public function print_detail_surat_berita_acara_penerimaan($id){
        $model = berita_acara::find($id);
        $berwenang =berwenang::where('level', 5)->where('user_id', Session::get('user_id'))->first();
        $instance =instansi::where('user_id', Session::get('user_id'))->first();
        $tahun_anggaran = tahun_anggaran::where('user_id', Session::get('user_id'))->where('status',1)->first();
        $data=[
            'berita_acara'=> $model,
            'tanggal'=>$this->tanggal($model->tgl_berita_acara),
            'tanggal_surat_keputusan'=>$this->tanggal($model->tgl_surat_keputusan),
            'tahun_anggaran'=> $tahun_anggaran,
            'berwenang' => $berwenang,
            'instansi' => $instance
        ];
        return view('content2.report.report_note_berita_acara_penerimaan_pekerjaan', $data);
    }


    //================================= Berita Acara Serah Terima Pekerjaan Pembelian Alat =============================

    public function daftar_berita_acara_serah_terima_pekerjaan(){
        $model = serah_terima_pekerjaan::all()->where('user_id', Session::get('user_id'))->sortByDesc('tgl_berita_acara');;
        $data = [
            'data_nota'=> $model
        ];
        return view('content2.note_berita_acara_serah_terima_pekerjaan.index', $data);
    }

    public function tambah_berita_acara_serah_terima_pekerjaan(){
        $model_berita_acara = berita_acara::all()->where('user_id', Session::get('user_id'));
        $berwenang = berwenang::all()->where('user_id', Session::get('user_id'));
        $data = [
            'data_berita_acara' => $model_berita_acara,
            'berwenang'=> $berwenang
        ];
        return view('content2.note_berita_acara_serah_terima_pekerjaan.new', $data);
    }


    public function store_berita_acara_serah_terima_pekerjaan(Request $req){
        $this->validate($req, [
            'berita_acara_penerimaan_id'=> 'required',
            'nomor_surat'=> 'required',
            'nomor_surat_perintah' => 'required',
            'tgl_surat_perintah' => 'required',
            'tanggal_serah_terima'=>'required',
            'mengetahui'=> 'required'
        ]);

        $berita_acara_penerimaan_id = $req->berita_acara_penerimaan_id;
        $nomor_surat = $req->nomor_surat;
        $nomor_surat_perintah = $req->nomor_surat_perintah;
        $tgl_surat_perintah = $req->tgl_surat_perintah;
        $tanggal_serah_terima = $req->tanggal_serah_terima;
        $berwenang = $req->mengetahui;
        $master_id = Session::get('user_id');

        $model = new NoteBeritaAcaraSerahTerimaPekerjaan();
        $model->berita_acara_penerimaan_id = $berita_acara_penerimaan_id;
        $model->nomor_surat = $nomor_surat;
        $model->tanggal_serah_terima = date('Y-m-d', strtotime($tanggal_serah_terima));
        $model->nomor_surat_perintah = $nomor_surat_perintah;
        $model->tgl_surat_perintah = date('Y-m-d', strtotime($tgl_surat_perintah));
        $model->user_id = $master_id;
        $model->mengetahui= $berwenang;

        if($model->save()){
            $req->session()->flash('message_success','Berita Acara Serah terima pekerjaan pembelian Telah berhasill dibuat');
            return redirect('berita_acara_serah_terima_pekerjaan_pembelian');
        }

        $req->session()->flash('message_fal','Berita Acara Serah terima pekerjaan pembelian gagal dibuat');
        return redirect('tambah_berita_acara_serah_terima_pekerjaan');

    }

    public function edit_berita_acara_serah_terima_pekerjaan($id){
        $model_berita_acara = berita_acara::all()->where('user_id', Session::get('user_id'));
        $model_berita_acara_serah_terima_pekerjaan = serah_terima_pekerjaan::find($id);
        $berwenang = berwenang::all()->where('user_id', Session::get('user_id'));

        $data = [
            'data_berita_acara' => $model_berita_acara,
            'data' => $model_berita_acara_serah_terima_pekerjaan,
            'berwenang'=> $berwenang
        ];
        return view('content2.note_berita_acara_serah_terima_pekerjaan.edit', $data);
    }

    public function update_berita_acara_serah_terima_pekerjaan(Request $req, $id){
        $this->validate($req, [
            'berita_acara_penerimaan_id'=> 'required',
            'nomor_surat'=> 'required',
            'nomor_surat_perintah' => 'required',
            'tgl_surat_perintah' => 'required',
            'tanggal_serah_terima'=>'required',
            'mengetahui'=> 'required'
        ]);

        $berita_acara_penerimaan_id = $req->berita_acara_penerimaan_id;
        $nomor_surat = $req->nomor_surat;
        $nomor_surat_perintah = $req->nomor_surat_perintah;
        $tgl_surat_perintah = $req->tgl_surat_perintah;
        $tanggal_serah_terima = $req->tanggal_serah_terima;
        $master_id = Session::get('user_id');
        $mengetahui = $req->mengetahui;

        $model = NoteBeritaAcaraSerahTerimaPekerjaan::find($id);
        $model->berita_acara_penerimaan_id = $berita_acara_penerimaan_id;
        $model->nomor_surat = $nomor_surat;
        $model->tanggal_serah_terima = date('Y-m-d', strtotime($tanggal_serah_terima));
        $model->nomor_surat_perintah = $nomor_surat_perintah;
        $model->tgl_surat_perintah = date('Y-m-d', strtotime($tgl_surat_perintah));
        $model->user_id = $master_id;
        $model->mengetahui = $mengetahui;

        if($model->save()){
            $req->session()->flash('message_success','Anda telah berhasil mengubah Berita Acara Serah terima pekerjaan pembelian');
            return redirect('berita_acara_serah_terima_pekerjaan_pembelian');
        }

        $req->session()->flash('message_fal','Anda telah gagal mengubah Berita Acara Serah terima pekerjaan pembelian');
        return redirect('tambah_berita_acara_serah_terima_pekerjaan');

    }


    public function delete_berita_acara_serah_terima_pekerjaan(Request $req, $id){
        $model = NoteBeritaAcaraSerahTerimaPekerjaan::find($id);
        if($model->delete()){
            $req->session()->flash('message_success','Anda telah berhasil menghapus Berita Acara Serah terima pekerjaan pembelian');
            return redirect('berita_acara_serah_terima_pekerjaan_pembelian');
        }
        $req->session()->flash('message_fal','Anda telah gagal menghapus Berita Acara Serah terima pekerjaan pembelian');
        return redirect('tambah_berita_acara_serah_terima_pekerjaan');
    }

    public function rincian_berita_acara_serah_terima_pekerjaan($id){
        $model_berita_acara_serah_terima_pekerjaan = NoteBeritaAcaraSerahTerimaPekerjaan::find($id);
        $data=[
            'berita_acara'=> $model_berita_acara_serah_terima_pekerjaan,
            'tanggal_hari_ini' => $this->tanggal($model_berita_acara_serah_terima_pekerjaan->tanggal_serah_terima)
        ];
        return view('content2.note_berita_acara_serah_terima_pekerjaan.rincian_barang.index', $data);
    }

    public function print_rincian_berita_acara_serah_terima_pekerjaan($id){
        $model_berita_acara_serah_terima_pekerjaan = NoteBeritaAcaraSerahTerimaPekerjaan::find($id);
        $instance =instansi::where('user_id', Session::get('user_id'))->first();
        $data=[
            'berita_acara'=> $model_berita_acara_serah_terima_pekerjaan,
            'tanggal_hari_ini' => $this->tanggal($model_berita_acara_serah_terima_pekerjaan->tanggal_serah_terima),
            'instansi' => $instance
        ];
        return view('content2.report.report_note_berita_acara_serah_terima_pekerjaan', $data);
    }

    public function tanggal($tanggal){
        $pecah_tanggal = explode('-', $tanggal);
        $dt = Carbon::parse($tanggal,'UTC');
        $pecah=$dt->format('l-F-Y');
        $pecah_hari = explode('-', $pecah);
        $array = [
            'hari'=> $this->translate_hari($pecah_hari[0]),
            'tanggal'=>$pecah_tanggal[2],
            'bulan' =>$this->translate_bulan($pecah_hari[1]),
            'tahun'=> $this->terbilang($pecah_tanggal[0]),
            'tahun_bil'=> $pecah_tanggal[0]
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
