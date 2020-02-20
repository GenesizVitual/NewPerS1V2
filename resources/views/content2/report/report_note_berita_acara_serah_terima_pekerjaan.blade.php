<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- jQuery 3 -->
    <script src="{{ asset('assets2/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets2/bower_components/paper/jQuery.print.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/paper/paper.css') }}">
    <style>@page { size: legal }</style>
</head>
<style type="text/css">
    .header img { width: 90px;float:left; margin-top: -3mm}
    .header h4  { font-size: 11pt; line-height: 3mm; text-align:center;}
    hr {border-color: black; margin: 5px 0;}
    .title {margin-top: 10mm;text-align: center;}
    .title h4 {font-size: 11pt; line-height: 3mm; font-weight: bold;text-decoration: underline;}
    .title h3 {font-size: 11pt; line-height: 3mm;margin-top: 10px;}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 8mm;text-align: justify;}
    .content label {font-weight: normal;margin-bottom: 0}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;}
    .content h4 p {margin-left: 35mm;}
    .roman{list-style-type: upper-roman;padding-inline-start: 3mm;}
    .roman li p {margin-bottom: 0}
    .roman li h3 {font-size : 10pt; line-height: 6mm;margin: 0 0 10px -3mm;}
    .alpha {list-style-type: lower-alpha;padding-inline-start: 5mm;}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    .footer {margin-top: 10mm;}
    .footer p{font-size: 10pt;line-height: 3mm;float: right}
    .footer table tr td{text-align: center}
    .footer tr,
    .footer td {border: none;padding-top: 5px; padding-bottom: 5px;}
    .footer tr:first-child td{vertical-align: bottom;width: 50%}
    .hr {display: inline-block;}
    .hr:after {content: '';display: block;border-top: 1px solid #000;margin-top:5px;}
    .footer h3 {font-size: 10pt;line-height: 3mm;margin-top: 0;margin-bottom: 5px;}
</style>
<body class="legal print-area">
    <section class="sheet padding-10mm">
        <section class="header">
            <img src="{{ asset('logo/'. $instansi->logo) }}" alt="Logo belum diunggah">
            @php($tingkat="")
            @switch($instansi->tingkat)
                @case('1')
                {{--//Provinsi--}}
                @php($tingkat="Provinsi")
                @break
                @case('2')
                {{--Kota {{ $instansi->getDistrict->district }}--}}
                @php($tingkat="Kota")
                @break
                @case('3')
                {{--Kabupaten {{ $instansi->getDistrict->district }}--}}
                @php($tingkat="Kabupaten")
                @break
                @default
                <label style="color: red;"> anda belum memilih tingkatan pada instansi </label>
            @endswitch
            @php($instansi_baru= str_replace($tingkat.' '.$instansi->getProvince->province,'',$instansi->instance))
            <H4>{{ strtoupper($instansi_baru) }}</H4>
            <h4>PROVINSI {{ strtoupper($instansi->getProvince->province) }}</h4>
            <h4>{{ $instansi->alamat }}</h4>
            <h4>No.Telp/Fax: {{ $instansi->no_telp }} - {{ $instansi->fax }}</h4>
        </section>
        <hr style="border-width: 3px;">
        <hr style="border-width: 1px;">
        <section class="title">
            <h4>BERITA ACARA SERAH TERIMA PEKERJAAN</h4>
            <h4>{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_belanja->name_belanja }}</h4>
            <h3>Nomor : {{ $berita_acara->nomor_surat }}</h3>
        </section>
        <section class="content">
            <p>Pada hari ini {{ $tanggal_hari_ini['hari'] }} tanggal {{ $tanggal_hari_ini['tanggal'] }} bulan {{ $tanggal_hari_ini['bulan'] }} Tahun <b>{{ $tanggal_hari_ini['tahun'] }}</b>, Kami yang bertanda tangan di bawah ini:</p>
            <ol class="roman">
                <li>
                    <p>Pemberi Perkerjaan :</p>
                    <label>
                        <h4><span>Nama</span> <p>: &nbsp; {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->nama_berwenang}}</p></h4>
                        <h4><span>Jabatan</span> <p>: &nbsp; Pejabat Pengadaan</p></h4>
                        <h4><span>Alamat</span> <p>: &nbsp; {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->alamat}}</p></h4>
                    </label>
                    <h3>Yang selanjutnya disebut Pihak Ke-I (Pemberi Pekerjaan)</h3>
                </li>
                <li>
                    <p>Pelaksana Perkerjaan :</p>
                    <label>
                        <h4><span>Nama</span> <p>: &nbsp; {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->pimpinan}}</p></h4>
                        <h4><span>Jabatan</span> <p>: &nbsp; Direktur {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers}}</p></h4>
                        <h4><span>Alamat</span> <p>: &nbsp; {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->alamat     }}</p></h4>
                    </label>
                    <h3>Yang selanjutnya disebut Pihak Ke-II (Pelaksana Pekerjaan)</h3>
                </li>
            </ol>
            <p>Telah melakukan Serah Terima Barang berdasarkan Surat Perintah Kerja Nomor: {{ $berita_acara->nomor_surat_perintah }} tanggal {{ date('d-m-Y', strtotime($berita_acara->tgl_surat_perintah)) }}, dimana Pihak Kedua menyerahkan kepada Pihak Kesatu semua Barang/Jasa : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_belanja->name_belanja }}
            {{ $instansi_baru }}
            @if($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='1')
                Provinsi {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getProvince->province }}

            @elseif($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='2')
                Kabupaten {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getDistrict->district }}
            @elseif($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='3')
                Kota {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getDistrict->district }}
            @endif
            dalam keadaan baik(100%) dengan ketentuan sebagai berikut:</p>
            <ol class="alpha">
                <li>Berdasarkan Berita Acara Penerimaan Hasil Pekerjaan Nomor : {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->nomor_berita_acara }}, tanggal {{ date('d-m-Y', strtotime($berita_acara->getBeritaAcara->getBeritaAcaraPH->tanggal_berita_acara)) }}</li>
                <li>Berdasarkan Berita Acara penerimaan Barang/Jasa Nomor : {{ $berita_acara->getBeritaAcara->nomor_surat_keputusan }}, tanggal {{ date('d-m-Y', strtotime($berita_acara->getBeritaAcara->tgl_surat_keputusan)) }}</li>
            </ol>
            <p>Demikian Berita Acara Penyerahan ini dibuat dalam rangkap 6 (enam) untuk dipergunakan sebagaimana mestinya.</p>
        </section>
        <section class="footer">
            <table>
                <tr height="35px">
                    <td>Yang Menerima Penyerahan,</td>
                    <td>Yang Menyerahkan,</td>
                </tr>
                <tr>
                    <td>Pihak I</td>
                    <td>Pihak II</td>
                </tr>
                <tr>
                    <td>Pejabat Pengadaan</td>
                    <td>{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers}}<br></td>
                </tr>
                <tr>
                    <td>{{ $instansi_baru }} <br> <br> @if($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='1')
                            Provinsi {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getProvince->province }}

                        @elseif($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='2')
                            Kabupaten {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getDistrict->district }}
                        @elseif($berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->tingkat=='3')
                            Kota {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_instansi->getDistrict->district }}
                        @endif</td>
                    <td>&nbsp</td>
                </tr>
                <tr height="70px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <h3 class="hr">{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_berwenang->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">{{ $berita_acara->getBeritaAcara->getBeritaAcaraPH->getNotaPesanan->get_supplier->pimpinan   }}</h3>
                        <h3>Direktur</h3>
                    </td>
                </tr>
                <tr height="30px" style="vertical-align: bottom">
                    <td colspan="2">Mengetahui,</td>
                </tr>
                <tr>
                    <td colspan="2">{{ $berita_acara->getAutorized->jabatan }},</td>
                </tr>
                <tr>
                    <td colspan="2">Selaku Kuasa Pengguna Anggaran</td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td colspan="2">
                        <h3 class="hr">{{ $berita_acara->getAutorized->nama_berwenang }}</h3>
                        <h3>NIP. {{ $berita_acara->getAutorized->nip}}</h3>
                    </td>
                </tr>
            </table>
        </section>
    </section>
</body>
<!-- DataTables -->
<script src="{{ asset('assets2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.print-area').print();
    })
</script>
</html>