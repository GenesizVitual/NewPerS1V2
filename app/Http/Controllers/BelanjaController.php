<?php

namespace App\Http\Controllers;

use App\Belanja;
use App\Helper\SessionCheck;
use App\Keg as kegiatan;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use Session;

use App\Note_receipt as nota;

use App\Rincian_barang_model as rincian_barang;

use App\Program as program;

use App\Fiscal_years as tahun_anggaran;

use App\Province as provinsi;

use App\Instance as instansi;

use App\Authorized as berwanang;

use Redirect;

class BelanjaController extends Controller
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


    public function checkSession()
    {
        if(empty(Session::get('user_id')))
        {
            return redirect('/');
        }
    }

    public function listBelanja($id)
    {
        $this->checkSession();
        $pass = $this->property($id, null);
        return view('content2.page_belanja.index', $pass);
    }
	
	 public function store($id, Request $req)
    {
        $master_id =Session::get('user_id');
        
        $this->validate($req,[
            'number_belanja'=> 'required',
            'name_belanja'=> 'required',
            'volume' => 'required',
            'unit' => 'required',
            'unit_price' => 'required',
        ]);
        
		$number_belanja = $req->number_belanja;
		$name_belanja = $req->name_belanja;
		$volume = $req->volume;
		$unit = $req->unit;
		$unit_price= $req->unit_price;
        $total_price =$unit_price*$volume;
		
        $belanja = new belanja([
           'number_belanja' => $number_belanja,
            'name_belanja' => $name_belanja,
            'volume'=>$volume,
            'unit'=>$unit,
            'unit_price'=>$unit_price,
            'total_price' => $total_price,
            'keg_id' => $id,
            'user_id'=>$master_id
        ]);
		
		 if($belanja->save()){
			 
			 $feedback = array(
                'status'=> true,
                'info'=> 'Data belanja berhasil di tambahkan'
            );

            return response()->json($feedback);
		 }else{
            $feedback = array(
                'status'=> true,
                'info'=> 'Data belanja gagal disimpan'
            );
            return response()->json($feedback);
        }

        return response()->json('');
    }
	
	
	private function property($id, $idBels){

        if($idBels == null){
            $models = null;
        }else{
            $models = belanja::find($idBels);
        }

        $pass = array(
            'belanja' => belanja::where('keg_id', $id)->where('user_id', Session::get('user_id'))->orderBy('number_belanja','asc')->get(),
            'dataForm'=>$models,
            'total_price'=>belanja::where('keg_id', $id)->sum('total_price'),
            'keg' => kegiatan::find($id)
        );
        return $pass;
    }
	
	public function edit($idkeg, $idGoods){
        $pass = $this->property($idkeg, $idGoods);
        return response()->json($pass);
    }
	
	 public function update($idGoods, Request $req)
    {
        $master_id =Session::get('user_id');

        $this->validate($req,[
			'number_belanja'=> 'required',
            'name_belanja'=> 'required',
            'volume'=> 'required',
            'unit' => 'required',
            'unit_price' => 'required',
        ]);

       
        $number_belanja = $req->number_belanja;
		$name_belanja = $req->name_belanja;
		$volume = $req->volume;
		$unit = $req->unit;
		$unit_price= $req->unit_price;
        $total_price =$unit_price*$volume;

        
        //ambil data belanja before changed
        $model_belanja = belanja::find($idGoods);
        
        $model_belanja->number_belanja=$number_belanja;
		$model_belanja->name_belanja=$name_belanja;
		$model_belanja->volume=$volume;
		$model_belanja->unit=$unit;
		$model_belanja->unit_price=$unit_price;
        $model_belanja->total_price=$total_price;

        if($model_belanja->save()){
            $feedback = array(
                'status'=> true,
                'info'=> 'sukses update belanja'
            );

            return $feedback;
        }
    }
	
	public function delete($idGoods, Request $req ){

        $belanja_model = belanja::find($idGoods);
      
        if($belanja_model->delete())
        {
            $feedback = array(
                'status'=> true,
                'info'=> 'Data Penerimaan Berhasil dihapus'
            );
            return $feedback;
        } else{

        $feedback = array(
            'status'=> false,
            'info'=> 'Data Tidak Bisa Dihapus'
        );
        return $feedback;
		}
    }

    public function report_realisasi_pakai_habis(){
	    return view('content2.report.report_realisasi_pakai_habis_content');
    }

    public function report_realisasi_pakai_habis_inspektorat(){
        return view('content_pInspektorat.report.report_realisasi_pakai_habis_content');
    }
    public function report_realisasi_pakai_habis_bpk(){
        return view('content_pbpk.report.report_realisasi_pakai_habis_content');
    }
    public function report_realisasi_pakai_habis_ins_pemkab(){
        return view('content_pInspektorat_pemkab.report.report_realisasi_pakai_habis_content');
    }
    public function report_realisasi_pakai_habis_ins_pemkot(){
        return view('content_pInspektorat_pemkot.report.report_realisasi_pakai_habis_content');
    }

    public function cetak_realisasi_pakai_habis(Request $req){

        $this->validate($req,[
            'tanggal_cetak'=>'required'
        ]);

        $instance =instansi::where('user_id', Session::get('user_id'))->first();
        $wilaya = provinsi::all()->where('user_id', Session::get('user_id'))->first();
        $atasan_langsung = berwanang::where('user_id', Session::get('user_id'))->where('level','4')->first();
        $penyimpan_barang = berwanang::where('user_id', Session::get('user_id'))->where('level','3')->first();


        $data =[
            'instansi' => $instance,
            'data'=>$this->get_data_realisasi(),
            'atasan_langsung'=> $atasan_langsung,
            'penyimpan_barang'=> $penyimpan_barang,
            'tgl_cetak'=>$req->tanggal_cetak
        ];

	    return view('content2.report.report_realisasi_pakai_habis', $data);
    }

    public function data_realisasi_pakai_habis(){

        return response()->json($this->get_data_realisasi());
    }

    public function get_data_realisasi(){
        $tahun_anggaran_aktif = tahun_anggaran::where('user_id',Session::get('user_id'))->where('status',1)->first();
        $model_program = program::all()->where('user_id', Session::get('user_id'))->where('fiscal_years_id',$tahun_anggaran_aktif->id);
        $colum = array();
        $no = 1;
        foreach ($model_program as $data_program){

            $model_kegiatan = DB::table('keg')
                ->join('belanja','belanja.keg_id','=','keg.id')
                ->where('keg.program_id', $data_program->id)
                ->select(DB::raw('sum(belanja.total_price) as jumlah_anggaran'))
                ->first();

            $rincian_belanja = DB::table('keg')
                ->join('belanja','belanja.keg_id','=','keg.id')
                ->join('note_receipt','note_receipt.belanja_id','=','belanja.id')
                ->join('rincian_barang','rincian_barang.id_nota','=','note_receipt.id')
                ->where('keg.program_id', $data_program->id)
                ->select(DB::raw('sum(rincian_barang.jumlah_harga) as jumlah_pemakaian_anggaran'))
                ->first();

            $row = array();
            $row[] = $no++;
            $row[] = "<td class='aleft'>".$data_program->account_code.'</td>';
            $row[] = $data_program->program_name;
            $row[] = number_format($model_kegiatan->jumlah_anggaran,2,'.',',');
            $row[] = number_format($rincian_belanja->jumlah_pemakaian_anggaran,2,'.','.');
            $row[] = number_format($model_kegiatan->jumlah_anggaran-$rincian_belanja->jumlah_pemakaian_anggaran,2,'.',',');;
            $colum[] = $row;
            foreach ($data_program->getKeg as $key2=>$data_kegiatan){

                $model_belanjas = belanja::where('keg_id', $data_kegiatan->id)->sum('total_price');
                $model_belanja = belanja::where('keg_id', $data_kegiatan->id)->first();
                $jumlah_rincian= 0;
                if(!empty($model_belanja)){
                    $model_nota=nota::where('belanja_id', $model_belanja->id)->first();
                    if(!empty($model_nota->id)){
                        $jumlah_rincian = rincian_barang::where('id_nota',$model_nota->id)->sum('jumlah_harga');
                    }
                }

                $row2= array();
                $row2[] = '';
                $row2[] = "<td class='aleft10'>".$data_kegiatan->number_keg.'</td>';
                $row2[] = $data_kegiatan->keg_name;
                $row2[] = number_format($model_belanjas,2,'.',',');
                $row2[] = number_format($jumlah_rincian,2,'.',',');
                $row2[] = number_format($model_belanjas-$jumlah_rincian,2,'.',',');
                $colum[] = $row2;

                foreach ($data_kegiatan->getSumBelanja as $key=> $data_belanja){
                    $total_rincian_price=0;
                    $total_price =$data_belanja->total_price;

                    if(!empty($data_belanja->getNotaReceipt[$key])){
                        $total_rincian_price = $data_belanja->getNotaReceipt[$key]->getRincianBelanja->sum('jumlah_harga');
                    }
                    $row3= array();
                    $row3[] = '';
                    $row3[] = "<td class='aleft15'>".$data_belanja->number_belanja.'</td>';
                    $row3[] = $data_belanja->name_belanja;
                    $row3[] = number_format($total_price ,2,'.',',');
                    $row3[] = number_format($total_rincian_price,2,'.',',');
                    $row3[] = number_format($total_price-$total_rincian_price, 2,'.',',');
                    $colum[] = $row3;
                }

            }
        }

        $model_kegiatan1 = DB::table('keg')
                ->join('belanja','belanja.keg_id','=','keg.id')
                ->join('program','program.id','=','keg.program_id')
                ->where('program.fiscal_years_id', $tahun_anggaran_aktif->id)
                ->select(DB::raw('sum(belanja.total_price) as jumlah_anggaran'))
                ->first();

            $rincian_belanja1 = DB::table('keg')
                ->join('belanja','belanja.keg_id','=','keg.id')
                ->join('program','program.id','=','keg.program_id')
                ->join('note_receipt','note_receipt.belanja_id','=','belanja.id')
                ->join('rincian_barang','rincian_barang.id_nota','=','note_receipt.id')
                ->where('program.fiscal_years_id', $tahun_anggaran_aktif->id)
                ->select(DB::raw('sum(rincian_barang.jumlah_harga) as jumlah_pemakaian_anggaran'))
                ->first();

        $output = array('data'=> $colum,'jumlah_belanja'=>$model_kegiatan1, 'jumlah_belanja_yang_dipakai'=>$rincian_belanja1);
        return $output;
    }
}
