<?php

namespace App\Http\Controllers\Simda;

use App\Helper\FormatKodeRekening;
use App\Helper\SessionCheck;
use App\Providers\KodeRekeningProfider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;
use App\Fiscal_years;
use App\Dpa;
use App\Program;
use App\Keg;
use App\Simda\Ta_Belanja_Rinc as Ta_belaja_rinc;
use App\Simda\Ta_Belanja_Rinc_Sub as Ta_belaja_rinc_sub;
use App\Belanja;

class SimtoToPersediaan extends Controller
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
                Session::flush();
                return redirect('login#login')->with('message_login_fail','Waktu Aktivasi Anda telah berakhir, Silahkan aktifasi ulang akun anda...!!');
            }

            return $next($req);
        });
    }


    public function importSimda(Request $req){
        $cek_tahun_akhif = Fiscal_years::where('status','1')->where('user_id', Session::get('user_id'))->first();
        if(empty($cek_tahun_akhif)){
           return redirect('program')->with('message_fail','Peringatan, Tahun aktif belum diaktifkan');
        }

        $dpa = Dpa::firstOrCreate(
            ['fiscal_years_id'=>$cek_tahun_akhif->id,'user_id'=>Session::get('user_id')],
            ['pagu_value'=>0]
        );

       // dd($req->all());

        foreach ($req->nama_program as $key_program=> $data_nama_program) //Proses Input Program
        {
            $kode_program = $req->kode_rekening[$key_program];
            $nama_program = $data_nama_program;
            $kode_kegiatan_unique = $req->input('kode_kegiatan_uniqe_'.$key_program);
            $kode_kegiatan_belanja_ = $req->input('kode_kegiatan_belanja_'.$key_program);
            $kode_kegiatan_ = $req->input('kode_kegiatan_'.$key_program);
            $nama_kegiatan = $req->input('nama_kegiatan_'.$key_program);
            $id_dpa = $dpa->id;
            $user_id = Session::get('user_id');


            $program_model = Program::updateOrCreate(
                ['account_code'=>$kode_program,'fiscal_years_id'=>$cek_tahun_akhif->id,'dpa_id'=>$id_dpa,'user_id'=>$user_id],
                ['program_name'=>$nama_program]
            );
            if($program_model){
                foreach ($kode_kegiatan_unique as $key_kegiatan => $kode_kegiatan){ //Proses Input Kegiatan
                    $number_keg_unique = $kode_kegiatan;
                    $number_keg = $kode_kegiatan_[$key_kegiatan];
                    $nama_kegiatans = $nama_kegiatan[$key_kegiatan];
                    $id_program = $program_model->id;

                    $model_keg = Keg::updateOrCreate(
                        ['unique_kode'=>$number_keg_unique,'program_id'=>$id_program,'user_id'=> $user_id],
                        ['number_keg'=>$number_keg,'keg_name'=>$nama_kegiatans]
                    );

                    if($model_keg){
                        $explode = explode('.', $kode_kegiatan_belanja_[$key_kegiatan]);
                        $kd_urusan=$explode[0];
                        $kd_unit=$explode[1];
                        $kd_bidang=$explode[2];
                        $kd_prog=$explode[3];
                        $kd_keg=$explode[4];
                        $kd_rek_1=$explode[5];
                        $kd_rek_2=$explode[6];
                        $kd_rek_3=$explode[7];
                        $kd_rek_4 =['1','6'];

                        $data = Ta_belaja_rinc::all()->where('Kd_Urusan',$kd_urusan)
                            ->where('Kd_Bidang',$kd_bidang)
                            ->where('Kd_Prog',$kd_prog)
                            ->where('Kd_Unit',$kd_unit)
                            ->where('Kd_Keg',$kd_keg)
                            ->where('Kd_Rek_1',$kd_rek_1)
                            ->where('Kd_Rek_2',$kd_rek_2)
                            ->where('Kd_Rek_3',$kd_rek_3)
                            ->whereIn('Kd_Rek_4', $kd_rek_4);
                        foreach ($data as $data_sub_belanja)
                        {
                            $data_belanja_rinc = Ta_belaja_rinc_sub::
                                  where('Kd_Urusan',$data_sub_belanja->Kd_Urusan)
                                ->where('Kd_Bidang',$data_sub_belanja->Kd_Bidang)
                                ->where('Kd_Prog',$data_sub_belanja->Kd_Prog)
                                ->where('Kd_Unit',$data_sub_belanja->Kd_Unit)
                                ->where('Kd_Keg',$data_sub_belanja->Kd_Keg)
                                ->where('Kd_Rek_1',$data_sub_belanja->Kd_Rek_1)
                                ->where('Kd_Rek_2',$data_sub_belanja->Kd_Rek_2)
                                ->where('Kd_Rek_3',$data_sub_belanja->Kd_Rek_3)
                                ->where('Kd_Rek_4', $data_sub_belanja->Kd_Rek_4)
                                ->where('Kd_Rek_5', $data_sub_belanja->Kd_Rek_5)->first();
                            $number_belanja = $data_belanja_rinc->Kd_Urusan.'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Bidang).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Prog).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Unit).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Keg).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Rek_1).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Rek_2).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Rek_3).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Rek_4).'.'.
                                FormatKodeRekening::kodeRekening($data_belanja_rinc->Kd_Rek_5);
                            $nama_belanja = $data_sub_belanja->Keterangan;
                            $volume = $data_belanja_rinc->Jml_Satuan;
                            $unit = $data_belanja_rinc->Satuan123;
                            $unit_price = $data_belanja_rinc->Nilai_Rp;
                            $total_price = $data_belanja_rinc->Total;
                            $keg_id = $model_keg->id;

                            $model_belanja = Belanja::updateOrCreate(
                                ['number_belanja'=>$number_belanja,'keg_id'=>$keg_id,'user_id'=>$user_id],
                                ['name_belanja'=>$nama_belanja,'volume'=>$volume,'unit'=>$unit,'unit_price'=>$unit_price,'total_price'=>$total_price]
                            );
                        }
                    }
                }
            }

        }

        return redirect('program')->with('import_status','Data Telah Berhasil diimport');
    }
}
