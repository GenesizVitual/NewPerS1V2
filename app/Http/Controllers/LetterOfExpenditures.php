<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Http\Request;

use App\Expenditures as pengeluaran;

use App\Sector as Bidang;

use App\Authorized as berwenang;

use App\Instance as instansi;

use App\LetterOfExpenditures as surat_permintaan;

use App\Province as provinsi;

use Illuminate\Support\Facades\DB;

use App\Fiscal_years as tahun_anggaran;

use Session;

use Validation;

use Redirect;
class LetterOfExpenditures extends Controller
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


    public function index(){
        $tahun_anggaran = tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $pass = array('surat_pengeluaran'=>surat_permintaan::whereyear('tgl_surat_keluar', $tahun_anggaran->years)->where('user_id',Session::get('user_id'))->get());
        return view('content2.page_letterofexpenditures.index', $pass);
    }

    public function create(){
        $pass = array(
            'bidang' => Bidang::all()->where('user_id', Session::get('user_id')),
            'ditujukan' => berwenang::all()->where('user_id', Session::get('user_id'))->where('level',2),
            'pengguna_barang' => berwenang::all()->where('user_id', Session::get('user_id'))->where('level',3),
        );
        return view('content2.page_letterofexpenditures.create', $pass);
    }

    public function store(Request $req){
        $this->validate($req,[
            'bidang' => 'required',
            'tgl_surat_permintaan' => 'required',
            'ditujukan' => 'required',
            'pengguna_barang'=> 'required',
            'tgl_cetak' => 'required'
        ]);

        $id_bindang = $req->bidang;
        $tgl_surat_permintaan = $req->tgl_surat_permintaan;
        $prihal = $req->prihal;
        $ditujukan = $req->ditujukan;
        $isi_surat = $req->isi_surat;
        $penutup_surat = $req->penutup_surat;
        $pengguna_barang = $req->pengguna_barang;
        $id_pengeluaran = $req->id_pengeluaran;
        $tgl_cetak = $req->tgl_cetak;

        $pecahKan_tgl_surat_permintaan = explode('-', $tgl_surat_permintaan);
        $bln_surat = $pecahKan_tgl_surat_permintaan[1];
        switch ($bln_surat) {
            case 1: {
                $bln_surat='I';
            } break;
            case 2: {
                $bln_surat='II';
            } break;
            case 3: {
                $bln_surat='III';
            } break;
            case 4: {
                $bln_surat='IV';
            } break;
            case 5: {
                $bln_surat='V';
            } break;
            case 6: {
                $bln_surat='VI';
            } break;
            case 7: {
                $bln_surat='VII';
            } break;
            case 8: {
                $bln_surat='VIII';
            } break;
            case 9: {
                $bln_surat='IX';
            } break;
            case 10: {
                $bln_surat='X';
            } break;
            case 11: {
                $bln_surat='XI';
            } break;
            case 12: {
                $bln_surat='XII';
            } break;
        }

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $bidang = Bidang::find($id_bindang );
        $tahun_anggaran = tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $no_surat_permintaan = surat_permintaan::whereYear('tgl_surat_keluar',$tahun_anggaran->years)->where('user_id', Session::get('user_id'))->count('id');
        $banyak_surat = $no_surat_permintaan;

        if($banyak_surat==0){
            $i=1;
        }else{
            $i=$banyak_surat+1;
        }

        switch ($i) {
            case 1: {
                $i='01';
            } break;
            case 2: {
                $i='02';
            } break;
            case 3: {
                $i='03';
            } break;
            case 4: {
                $i='04';
            } break;
            case 5: {
                $i='05';
            } break;
            case 6: {
                $i='06';
            } break;
            case 7: {
                $i='07';
            } break;
            case 8: {
                $i='08';
            } break;
            case 9: {
                $i='09';
            } break;
        }

        $no_surat_pengeluaran="SBM/".$i."/".$instansi->singkatan_instansi."/".$bidang->sector_name."/".$bln_surat."/".$pecahKan_tgl_surat_permintaan[2];

        $model_surat_permintaan = new surat_permintaan([
            'sector_id' => $id_bindang ,
            'no_surat_pengeluaran'=> $no_surat_pengeluaran,
            'tgl_surat_keluar' => date('Y-m-d', strtotime($tgl_surat_permintaan)),
            'prihal'=> $prihal,
            'ditujukan'=> $ditujukan,
            'isi_surat'=> $isi_surat,
            'penutup_surat'=> $penutup_surat,
            'pengguna_barang' => $pengguna_barang,
            'tgl_cetak' => date('Y-m-d', strtotime($tgl_cetak)),
            'id_pengeluaran'=>$id_pengeluaran,
            'user_id' => Session::get('user_id')
        ]);

        if($model_surat_permintaan->save()){
            //$pengeluaran_model = pengeluaran::where('out_date','=', date('Y-m-d', strtotime($tgl_surat_permintaan)))->update(['status_surat_pengeluaran'=>'1']);

            $id_pengeluaran_exp= explode(',', $id_pengeluaran);
            foreach ($id_pengeluaran_exp as $value){
                $pengeluaran_model = pengeluaran::where('id','=', $value)->update(['status_surat_pengeluaran'=>'1']);
            }

            if($pengeluaran_model ){
                return redirect('letterofExpenditure');
            }
        }
        $status= array(
            'status' => false,
            'info'=> 'Gagal Membuat Surat Pengeluaran'
        );
        return redirect('letterofExpenditure');

    }

    public function edit($id){
        $data_surat = surat_permintaan::find($id);
        $pengeluaran = explode(',', $data_surat->id_pengeluaran);
        $pass = array(
            'data_surat' => $data_surat,
            'pengeluaran' => pengeluaran::whereIn('id', $pengeluaran)->get(),
            'bidang' => Bidang::all()->where('user_id', Session::get('user_id')),
            'ditujukan' => berwenang::all()->where('user_id', Session::get('user_id'))->where('level',3),
            'pengguna_barang' => berwenang::all()->where('user_id', Session::get('user_id'))->where('level',2),
        );
        return view('content2.page_letterofexpenditures.edit', $pass);
    }

    public function update(Request $req, $id){
        $this->validate($req,[
            'bidang' => 'required',
            'tgl_surat_permintaan' => 'required',
            'ditujukan' => 'required',
            'pengguna_barang'=> 'required',
            'tgl_cetak' => 'required'
        ]);

        $id_bindang = $req->bidang;
        $tgl_surat_permintaan = $req->tgl_surat_permintaan;
        $prihal = $req->prihal;
        $ditujukan = $req->ditujukan;
        $isi_surat = $req->isi_surat;
        $penutup_surat = $req->penutup_surat;
        $pengguna_barang = $req->pengguna_barang;
        $id_pengeluaran = $req->id_pengeluaran;
        $tgl_cetak = $req->tgl_cetak;

        $pecahKan_tgl_surat_permintaan = explode('-', $tgl_surat_permintaan);
        $bln_surat = $pecahKan_tgl_surat_permintaan[1];
        switch ($bln_surat) {
            case 1: {
                $bln_surat='I';
            } break;
            case 2: {
                $bln_surat='II';
            } break;
            case 3: {
                $bln_surat='III';
            } break;
            case 4: {
                $bln_surat='IV';
            } break;
            case 5: {
                $bln_surat='V';
            } break;
            case 6: {
                $bln_surat='VI';
            } break;
            case 7: {
                $bln_surat='VII';
            } break;
            case 8: {
                $bln_surat='VIII';
            } break;
            case 9: {
                $bln_surat='IX';
            } break;
            case 10: {
                $bln_surat='X';
            } break;
            case 11: {
                $bln_surat='XI';
            } break;
            case 12: {
                $bln_surat='XII';
            } break;
        }

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $bidang = Bidang::find($id_bindang );
        $tahun_anggaran = tahun_anggaran::where('status','1')->where('user_id',Session::get('user_id'))->first();
        $no_surat_permintaan = surat_permintaan::whereYear('tgl_surat_keluar',$tahun_anggaran->years)->where('user_id', Session::get('user_id'))->count('id');
        $banyak_surat = $no_surat_permintaan;
        if($banyak_surat==0){
            $i=1;
        }else{
            $i=$banyak_surat+1;
        }

        switch ($i) {
            case 1: {
                $i='01';
            } break;
            case 2: {
                $i='02';
            } break;
            case 3: {
                $i='03';
            } break;
            case 4: {
                $i='04';
            } break;
            case 5: {
                $i='05';
            } break;
            case 6: {
                $i='06';
            } break;
            case 7: {
                $i='07';
            } break;
            case 8: {
                $i='08';
            } break;
            case 9: {
                $i='09';
            } break;
        }

        $no_surat_pengeluaran="SBM/".$i."/".$instansi->singkatan_instansi."/".$bidang->sector_name."/".$bln_surat."/".$pecahKan_tgl_surat_permintaan[2];

//        new surat_permintaan([
//            'sector_id' => $id_bindang ,
//            'no_surat_pengeluaran'=> $no_surat_pengeluaran,
//            'tgl_surat_keluar' => date('Y-m-d', strtotime($tgl_surat_permintaan)),
//            'prihal'=> $prihal,
//            'ditujukan'=> $ditujukan,
//            'isi_surat'=> $isi_surat,
//            'penutup_surat'=> $penutup_surat,
//            'pengguna_barang' => $pengguna_barang,
//            'tgl_cetak' => date('Y-m-d', strtotime($tgl_cetak)),
//            'user_id' => Session::get('user_id')
//        ]);

        $model_surat_permintaan = surat_permintaan::find($id);
        $model_surat_permintaan->sector_id=$id_bindang;
        $model_surat_permintaan->no_surat_pengeluaran=$no_surat_pengeluaran;
        $model_surat_permintaan->tgl_surat_keluar=date('Y-m-d', strtotime($tgl_surat_permintaan));
        $model_surat_permintaan->prihal=$prihal;
        $model_surat_permintaan->ditujukan=$ditujukan;
        $model_surat_permintaan->isi_surat=$isi_surat;
        $model_surat_permintaan->penutup_surat=$penutup_surat;
        $model_surat_permintaan->pengguna_barang=$pengguna_barang;
        $model_surat_permintaan->id_pengeluaran=$id_pengeluaran;
        $model_surat_permintaan->tgl_cetak=date('Y-m-d', strtotime($tgl_cetak));

        if($model_surat_permintaan->save()){
            //$pengeluaran_model = pengeluaran::where('out_date','=', date('Y-m-d', strtotime($tgl_surat_permintaan)))->update(['status_surat_pengeluaran'=>'1']);
            $id_pengeluaran_exp = explode(',',$id_pengeluaran);
            foreach($id_pengeluaran_exp as $value){
                $pengeluaran_model = pengeluaran::where('id','=', $value)->update(['status_surat_pengeluaran'=>'1']);
            }

            if($pengeluaran_model ){
                return redirect('letterofExpenditure');
            }
        }
        $status= array(
            'status' => false,
            'info'=> 'Gagal Membuat Surat Pengeluaran'
        );
        return redirect('letterofExpenditure');
    }

    public function detele($id){
        $surat_pngeluaran_model = surat_permintaan::find($id);
        $tanggal_pengeluaran = explode(',',$surat_pngeluaran_model->id_pengeluaran);
        if($surat_pngeluaran_model->delete()){
            foreach ($tanggal_pengeluaran as $value){
                $pengeluaran_model = pengeluaran::where('id','=', $value)->update(['status_surat_pengeluaran'=>'0']);
            }
            if($pengeluaran_model ){
                return redirect('letterofExpenditure');
            }
        }
        $status= array(
            'status' => false,
            'info'=> 'Gagal Membuat Surat Pengeluaran'
        );
        return redirect('letterofExpenditure');
    }

    public function printLetter($id)
    {

        $instansi = instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
        $penyimpan_barang=berwenang::where('user_id', Session::get('user_id'))->where('level',5)->first();
        $surat_pengeluaran = surat_permintaan::find($id);
        $id_pengeluaran_exp = explode(',',$surat_pengeluaran->id_pengeluaran);
        $no=1;
        $container = array();
        foreach ($id_pengeluaran_exp as $value)
        {
            $pengeluaran = pengeluaran::find($value);
            $row=array();
            $row[] = $no++;
            $row[] = $pengeluaran->get_warehouse->goods_name;
            $row[] = $pengeluaran->get_warehouse->unit;
            $row[] = $pengeluaran->exit_item;
            $row[] = date('d-m-Y', strtotime($pengeluaran->out_date));
            $container[] = $row;
        }
        $output = array(
            'data' => $container,
            'surat_pengeluaran' => $surat_pengeluaran,
            'penyimpan_barangs'=>$penyimpan_barang,
            'instansi'=>$instansi,
        );
        return view('content2.report.report_letter_expendure', $output);
    }
}
