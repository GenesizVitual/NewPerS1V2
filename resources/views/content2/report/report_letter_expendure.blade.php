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
    .title h4 {font-size: 11pt; line-height: 3mm; font-weight: bold;}
    .title h3 {font-size: 11pt; line-height: 3mm;margin-top: 10px;}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 8mm;text-align: justify;}
    .content .start {text-indent: 5mm;}
    .content label {margin-bottom: 20px}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;font-weight: bold}
    .content h4 p {margin-left: 35mm;}
    .content h3 {font-size:10pt; line-height: 3mm; font-weight: bold;margin: 10px 0}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding-top: 5px; padding-bottom: 5px;}
    th {text-align: center;}
    tbody tr td{text-align: center;padding-left: 5px;}
    .footer {margin-top: 10mm;}
    .aleft {text-align: left;padding-left: 5px;}
    .footer p{font-size: 10pt;line-height: 3mm;float: right}
    .footer table tr td{text-align: center}
    .footer tr,
    .footer td {border: none}
    .footer tr:first-child td{vertical-align: bottom;width: 50%}
    .hr {display: inline-block;}
    .hr:after {content: '';display: block;border-top: 1px solid #000;margin-top:5px;}
    .footer h3 {font-size: 10pt;line-height: 3mm;margin-top: 0;margin-bottom: 5px;}
</style>
<body class="legal print-area">
    <section class="sheet padding-10mm">
        <section class="header">
            <img src="{{ asset('logo/'. $instansi->logo) }}" alt="Logo belum diunggah">
            <h4>{{ strtoupper($instansi->instance) }}
                @switch($instansi->tingkat)
                    @case('1')
                    {{--//Provinsi--}}
                    @break
                    @case('2')
                    KOTA {{ $instansi->getDistrict->district }}
                    @break
                    @case('3')
                     KABUPATEN {{ strtoupper($instansi->getDistrict->district) }}
                    @break
                    @default
                    <label style="color: red;"> anda belum memilih tingkatan pada instansi </label>
                @endswitch
            </h4>
            <h4>PROVINSI {{ strtoupper($instansi->getProvince->province) }}</h4>
            <h4>{{ $instansi->alamat }}</h4>
            <h4>No.Telp/Fax: {{ $instansi->no_telp }} - {{ $instansi->fax }}</h4>
        </section>
        <hr style="border-width: 3px;">
        <hr style="border-width: 1px;">
        <section class="title">
            <h4>SURAT PENGELUARAN BARANG</h4>
        </section>
        <section class="content">
            <label>
                <h4><span>Nomor</span> <p>: &nbsp; {{ $surat_pengeluaran->no_surat_pengeluaran }}</p></h4>
                <h4><span>Bidang</span> <p>: &nbsp; {{ $surat_pengeluaran->getSector->sector_name }}</p></h4>
                <h4><span>Perihal</span> <p>: &nbsp; {{ $surat_pengeluaran->prihal }}</p></h4>
            </label>
            <h3>Kepada</h3>
            <h3>Yth. {{ $surat_pengeluaran->get_tujukan->nama_berwenang }}</h3>
            <h3>Di Tempat</h3>
            <br>
            <p class="start">{{ $surat_pengeluaran->isi_surat }}</p>
            <table id="table_penerimaan">
                <thead>
                    <tr>
                        <th>No</th>
                        {{--<th>Nama Bidang</th>--}}
                        <th class="aleft">Nama Barang </th>
                        <th>Unit</th>
                        <th>Jumlah Barang</th>
                        {{--<th>Tanggal Keluar</th>--}}
                    </tr>
                </thead>
                <tbody>
                    @php($i=1)
                    @foreach($data as $colum)
                        <tr>
                            <td>{{ $colum[0] }}</td>
                            <td class="aleft">{{ $colum[1] }}</td>
                            <td>{{ $colum[2] }}</td>
                            <td>{{ $colum[3] }}</td>
                            {{--<td>{{ $colum[4] }}</td>--}}

                        </tr>
                    @endforeach
                </tbody>
            </table>
            <p class="start">{{ $surat_pengeluaran->penutup_surat }}</p>
        </section>
        <section class="footer">
            <p>{{ $instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($surat_pengeluaran->tgl_cetak)) }}</p>
            <table>
                <tr height="35px">
                    <td>
                        @if(!empty($surat_pengeluaran))
                        Pengguna Barang
                        @else
                        Kepala bidang Belum dimasukan
                        @endif
                    </td>
                    <td>
                        @if(!empty($surat_pengeluaran))
                        Pengurus Barang
                        @else
                        Pengguna Barang belum dimasukan
                        @endif
                    </td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                @if(!empty($surat_pengeluaran))
                <tr>
                    <td>
                        <h3 class="hr">( {{ $surat_pengeluaran->get_tujukan->nama_berwenang }} ) </h3>
                        <h3>NIP. {{ $surat_pengeluaran->get_tujukan->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">( {{ $surat_pengeluaran->get_pengguna_barang->nama_berwenang }} )</h3>
                        <h3>NIP. {{ $surat_pengeluaran->get_pengguna_barang->nip }}</h3>
                    </td>
                </tr>
                @endif
            </table>
        </section>
    </section>
<script>
    $(document).ready(function() {
        $('.print-area').print();
    })
</script>
</html>