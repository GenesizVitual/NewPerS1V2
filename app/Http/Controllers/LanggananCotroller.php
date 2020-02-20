<?php

namespace App\Http\Controllers;

use App\Helper\SessionCheck;
use Illuminate\Support\Facades\DB;

use App\Langganan as langganan;

use Illuminate\Http\Request;

use App\PaketPrice as paket_price;

use App\PriodePaket as priode_paket;

use App\Dpa as pagu;

use App\Fiscal_years as tahun_anggaran;

use DateTime;

use App\UserInfo as info_user;

use App\Instance as instansi;

use App\Confirm_langganan as konfirmasi_langganan;

use Session;

use Carbon\Carbon;

class LanggananCotroller extends Controller
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
        $data_unpaid =langganan::where(function ($query){
            $query->where('status','0');
            $query->orWhere('status','1');
        })-> where('user_id', Session::get('user_id'))
        ->get();
        $date_now = date('Y-m-d');

        $data_paid =langganan::all()->where('user_id', Session::get('user_id'))->where('status','3');
        $cek_langganan = langganan::where('user_id', Session::get('user_id'))->where('status_aktif', '1')->first();
        $cek_langganan_terakhir = langganan::where('id', $cek_langganan->id)->where('end_date','>', $date_now)->get();
        //dd($cek_langganan_terakhir);
        //dd(count($cek_langganan_terakhir));
        return view('content2.page_langganan.index2', array('data'=> $data_unpaid,'data_paid'=>$data_paid, 'status_pembayaran'=> $cek_langganan_terakhir));
    }

    public function create()
    {
        $tahun_anggaran = tahun_anggaran::all()->where('user_id',Session::get('user_id'))->where('status',1)->first();
        if(empty($tahun_anggaran)){
            $info = [
              'info' => 'Pengaturan Awal belum sepenuhnya diisi'
            ];
            return redirect('daftartagihan')->with($info);
        }else{
            $pagu = pagu::where('user_id', Session::get('user_id'))->where('fiscal_years_id',$tahun_anggaran->id)->get();
        }
        $pass = [
            'paket_price'=> paket_price::all(),
            'priode_paket'=> priode_paket::all(),
            'pagu'=>$pagu
        ];
        return view('content2.page_langganan.new', $pass);
    }

    public function getPrice($id)
    {
        $find = paket_price::find($id);
        return response()->json($find);
    }

    public function getPeriode($id)
    {
        $find = priode_paket::find($id);
        return response()->json($find);
    }

    public function prosesLangganan(Request $req)
    {
        $this->validate($req,[
            'harga_paket' => 'required',
            'periode_paket' => 'required'
        ]);

        $paket_price_id = $req->harga_paket;
        $periode_paket = $req->periode_paket;
        //ambil periode
        $periode = priode_paket::find($periode_paket);
        $tanggal = Carbon::now();
        $tanggal_mulai=$tanggal->toDateString();
        $cari_periode = $tanggal->addMonth($periode->value);
        $tanggal_akhir=$cari_periode->toDateString();

        $langganan_model = new Langganan();
        $langganan_model->paket_harga_id=$paket_price_id;
        $langganan_model->priode_paket_id=$periode_paket;
        $langganan_model->begin_date=$tanggal_mulai;
        $langganan_model->end_date=$tanggal_akhir;
        $langganan_model->status=1;
        $langganan_model->user_id=Session::get('user_id');

        if($langganan_model->save())
        {
            $req->session()->flash('message_success', 'Anda berhasil berlangganan');
            return redirect('daftartagihan');
        }
        $req->session()->flash('message_success', 'Maaf terjadi kesalahan');
        return redirect('daftartagihan');
    }

    public function informasi()
    {
        $langganan_model = langganan::where('user_id', Session::get('user_id'))->where(function($query){
            $query->where('status','0');
            $query->orWhere('status','1');
        })->orderBy('begin_date', 'asc')->where('status_aktif','1')->first();
        $tgl_sekarang = Carbon::now();

        if(!empty($langganan_model->end_date)){
            if($tgl_sekarang->toDateString() >= $langganan_model->end_date){
                $langganan_model->status_aktif = '0';
                $langganan_model->save();
            }


            $pecahkan_tanggal = explode('-',$langganan_model->end_date);

            $mks = DB::table('info_langganan')->select('id', DB::raw('date(created_at) as tgl_buat'))->where('user_id', Session::get('user_id'))->orderBy('created_at')->first();

            $tanggal = Carbon::create($pecahkan_tanggal[0], $pecahkan_tanggal[1], $pecahkan_tanggal[2]);
            $dua_minggu_sebelum_jatuh_tempo = $tanggal->subWeek(2)->toDateString();
            $tanggal_sekarang = Carbon::now();
            $subTanggalSekaran = $tanggal_sekarang->toDateString();

            if($dua_minggu_sebelum_jatuh_tempo <= $subTanggalSekaran) {
                $pesan = "Massa aktif acount anda akan habis pada tanggal :" . $langganan_model->end_date;
                $user_id = Session::get('user_id');

                $modelInfo = new info_user();
                $modelInfo->msg = $pesan;
                $modelInfo->user_id = $user_id;
                if(!empty($mks->tgl_buat))
                {
                    if($mks->tgl_buat != $subTanggalSekaran)
                    {
                        $modelInfo->save();
                    }
                }else{
                    if($dua_minggu_sebelum_jatuh_tempo <= $subTanggalSekaran) {
                        $modelInfo->save();
                    }
                }
            }
        }else{
            $json =  [
                'informasi' => 'Anda belum berlangganan',
                'status' => false
            ];
            return response()->json($json);
        }
        //return $subTanggalSekaran .'-----'.$dua_minggu_sebelum_jatuh_tempo;
    }

    public function detail($id)
    {
        $langganan_model = langganan::find($id);
        $instansi_model = instansi::where('user_id', Session::get('user_id'))->first();
        return view('content2.page_langganan.invoice', array('data'=> $langganan_model, 'instansi'=> $instansi_model));
    }

    public function detail_print($id)
    {
        $langganan_model = langganan::find($id);
        $instansi_model = instansi::where('user_id', Session::get('user_id'))->first();
        return view('content2.page_langganan.invoice_print', array('data'=> $langganan_model, 'instansi'=> $instansi_model));
    }

    public function konfirmasi($id)
    {
        $langganan_model = langganan::find($id);
        return view('content2.page_langganan.confirm', array('data'=> $langganan_model));
    }

    public function prosesConfirm(Request $req, $id)
    {
        $this->validate($req,[
            'bank_tujuan' => 'required',
            'pengirim_bank' => 'required',
            'no_rek_pengirim' => 'required',
            'nama_pengirim' => 'required',
            'tanggal_pengirim' => 'required',
            'nilai_transfer' => 'required',
            'image' => 'required|image|mimes:jpeg,png,gif,jpg|max:2048',
        ]);

        $tagihan = langganan::find($id);

        $bank_tujuan = $req->bank_tujuan;
        $pengirim_bank = $req->pengirim_bank;
        $no_rek_pengirim = $req->no_rek_pengirim;
        $nama_pengirim= $req->nama_pengirim;
        $tanggal_pengirim= $req->tanggal_pengirim;
        $nilai_transfer= $req->nilai_transfer;
        $bukti_tranfer= $req->image;
        $catatan= $req->catatan;


        $imagename = time(). '.' . $bukti_tranfer->getClientOriginalExtension();

        $confirmasi_model = new konfirmasi_langganan();
        $confirmasi_model->bank_tujuan = $bank_tujuan;
        $confirmasi_model->bank_pengirim = $pengirim_bank;
        $confirmasi_model->no_rekening_bank = $no_rek_pengirim;
        $confirmasi_model->nama_pengirim = $nama_pengirim;
        $confirmasi_model->tanggal_pengirim = date('Y-m-d', strtotime($tanggal_pengirim));
        $confirmasi_model->total_transfer = $nilai_transfer;
        $confirmasi_model->nama_bukti_rekening = $imagename;
        $confirmasi_model->catatan = $catatan;
        $confirmasi_model->tagihan_id = $id;
        $confirmasi_model->user_id = Session::get('user_id');

        if($confirmasi_model->save())
        {
            $tagihan->status=2;
            $tagihan->save();

            if($bukti_tranfer->move(public_path('file_rek'), $imagename))
            {
                $req->session()->flash('message_success', 'Tagihan anda telah diproses');
                return redirect('daftartagihan');
            }else{
                $req->session()->flash('message_fail','Gagal mengupload bukti tranfer. mohon lakukan konfirmasi ulang');
                return redirect('daftartagihan');
            }
        }
        $req->session()->flash('message_fail','Gagal mengupload bukti tranfer. mohon lakukan konfirmasi ulang');
        return redirect('daftartagihan');
    }

    //======================================================Superadmin==================================================

    public function dataLangganana()
    {
        $pengguna_yg_belum_membayar = langganan::all()->where('status_aktif', '0')->where('status',0); // pengguna yang belum langganan
        $pengguna_yg_sudah_langganan = langganan::all()->where('status', 1); // pengguna yang sudah berlangganan
        $pengguna_yang_sudah_konfirmasi = langganan::all()->where('status', 2); // pengguna yang sudah melakukan konfirmasi pelanggan
        $pengguna_yang_sudah_diaktifkan_accoutnnya= langganan::all()->where('status',3)->where('status_aktif', 1);
        $data = [
            'belum_bayar' => $pengguna_yg_belum_membayar,
            'sudah_langganan' => $pengguna_yg_sudah_langganan,
            'sudah_konfimrasi' => $pengguna_yang_sudah_konfirmasi,
            'sudah_aktif_accountnya' => $pengguna_yang_sudah_diaktifkan_accoutnnya
        ];
        //return response()->json($data);
        return view('content_superadmin.langganan.content', $data);
    }

    public function dataStruck($id_stuck)
    {
        $data = [
            'confirm'=> konfirmasi_langganan::where('tagihan_id', $id_stuck)->first()
        ];
        return response()->json($data);
    }

    public function update_status_aktif(Request $req, $id){
        $model_langganan= langganan::find($id);
        $model_langganan->status_aktif = 0;
        if($model_langganan->save()){
            $data =[
                'info'=> "Akun sudah di aktifkan",
                'status'=> "true"
            ];
            return response()->json($data);
        }

        $data =[
            'info'=> "Akun gagal diaktifkan",
            'status'=> "false"
        ];
        return response()->json($data);
    }

    public function off_langganan(Request $req, $id){
        $model_langganan= langganan::find($id);
        $model_langganan->status = 1;
        $model_langganan->status_aktif = 0;
        if($model_langganan->save()){
            $data =[
                'info'=> "Akun sudah di tidak Aktif",
                'status'=> "true"
            ];
            return response()->json($data);
        }

        $data =[
            'info'=> "Akun gagal diaktifkan",
            'status'=> "false"
        ];
        return response()->json($data);
    }
	public function memberbiasa()
	{
		return view('content2.page_langganan.memberbiasa');
	}

}
