
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman detail berita acara serah terima pekerjaan
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail berita acara serah terima pekerjaan </h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('cetak_rincian_berita_acara_serah_terima_pekerjaan/'. $berita_acara->id.'/detail') }}" target="_blank" class="btn btn-default">Cetak Surat BASTP</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <p style="text-align: center; font-size: large; font-weight: bold">
                            <u>BERITA ACARA SERAH TERIMA PEKERJAAN <br>{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_belanja->name_belanja }}</u>
                        </p>
                        <p style="text-align: center; font-size: medium;">
                            Nomor : {{ $berita_acara->nomor_surat }}
                        </p>
                        <br>
                        <br>
                        <p>
                            Pada hari ini {{ $tanggal_hari_ini['hari'] }} tanggal {{ $tanggal_hari_ini['tanggal'] }} bulan {{ $tanggal_hari_ini['bulan'] }} Tahun <b>{{ $tanggal_hari_ini['tahun'] }}</b>, Kami yang bertanda tangan di bawah ini:
                        </p>
                        <p style="padding-left: 2%">
                            <ul>
                                I. Pemberi Perkerjaan : <br>
                                <ul style="padding-left: 1%">
                                    Nama : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->nama_berwenang}}
                                    <br>
                                    Jabatan : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->jabatan}}
                                    <br>
                                    Alamat&nbsp;: <br>
                                    Yang selanjutnya disebut Pihak Ke-1(Pemberi Pekerjaan).
                                </ul>
                            </ul>
                            <ul>
                                II. Pelaksana Perkerjaan : <br>
                                <ul style="padding-left: 1%">
                                     Nama : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->pimpinan	 }}
                                    <br>
                                     Jabatan : Direktur  {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers}}
                                    <br>
                                     Alamat&nbsp;:  {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->alamat	 }}<br>
                                     Yang selanjutnya disebut Pihak Ke-1(Pemberi Pekerjaan).
                                </ul>
                            </ul>
                        </p>
                        <br>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;Telah melakukan Serah Terima Barang berdasarkan Surat Perintah Kerja Nomor: {{ $berita_acara->nomor_surat_perintah }} tanggal {{ date('d-m-Y', strtotime($berita_acara->tgl_surat_perintah)) }}, dimana Pihak Kedua menyerahkan kepada Pihak Kesatu semua Barang/Jasa : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_belanja->name_belanja }}
                            {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->instance }}
                            @if($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='1')
                                Provinsi {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getProvince->province }}

                            @elseif($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='2')
                                Kabupaten {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getDistrict->district }}
                            @elseif($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='3')
                                Kota {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getDistrict->district }}
                            @endif
                            dalam keadaan baik(100%) dengan ketentuan sebagai berikut:
                        </p>
                        <p style="padding-left: 2%">
                        <ul>
                            <p>a. Berdasarkan Berita Acara Penerimaan Hasil Pekerjaan Nomor : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->nomor_berita_acara }}, tanggal {{ date('d-m-Y', strtotime($berita_acara->getBeritaAcara->getBeritaAcaraPH->tanggal_berita_acara)) }}</p>
                        </ul>
                        <ul>
                            <p>b. Berdasarkan Berita Acara penerimaan Barang/Jasa Nomor : {{ $berita_acara->getBeritaAcara->nomor_surat_keputusan }}, tanggal {{ date('d-m-Y', strtotime($berita_acara->getBeritaAcara->tgl_surat_keputusan)) }}</p>
                        </ul>
                        </p>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp; Demikian Berita Acara Penyerahan ini dibuat dalam rangkap 6 (enam) untuk dipergunakan sebagaimana mestinya.
                        </p>
                        <br>
                        <div class="col-md-6">
                            <div style="padding-left: 5%; text-align: center;">
                                <p>Yang Menerima Penyerahan<br>Pihak I<br> Pejabat Pengadaan <br> {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->instance }}</p>
                                <br>
                                <br>
                                <p><u>{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->nama_berwenang }}</u></p>
                                <p>NIP &nbsp;&nbsp;:&nbsp;&nbsp;{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->nip }} </p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div style="padding-left: 50%;text-align: center;">
                                <p>Yang Menyerahkan, <br> Pihak II<br> {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers}}</p>
                                <p>
                                </p>
                                <br>
                                <br>
                                <br>
                                <p><u>{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->pimpinan	 }}</u></p>
                                <p>Direktur</p>
                            </div>
                        </div>
                        <div class="col-md-5 col-md-offset-4" style="align-content: center; text-align: center">
                            <p></p>
                            <p>Mengetahui,<br>{{ $berita_acara->getAutorized->jabatan }}, <br> Selaku<br> Kuasa Pengguna Anggaran</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u>{{ $berita_acara->getAutorized->nama_berwenang }}</u></p>
                            <p>NIP &nbsp;&nbsp;:&nbsp;&nbsp; {{ $berita_acara->getAutorized->nip}}</p>
                        </div>
                    </div>
                  </div>
            </div>
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


@stop

