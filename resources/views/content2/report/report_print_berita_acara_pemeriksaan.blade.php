<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Persediaan.id</title>
    <!-- jQuery 3 -->
    <script src="{{ asset('assets2/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets2/bower_components/paper/jQuery.print.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/paper/paper.css') }}">
    <style>@page { size: legal}</style>
</head>
<style>
    .header img { width: 90px;float:left; margin-top: -3mm}
    .header h4  { font-size: 11pt; line-height: 3mm; text-align:center;}
    hr {border-color: black; margin: 5px 0;}
    .title {margin-top: 10mm;text-align: center;}
    .title h4 {font-size: 11pt; line-height: 3mm; font-weight: bold;text-decoration: underline;}
    .title h3 {font-size: 11pt; line-height: 3mm;margin-top: 10px;font-weight: bold}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 8mm;text-align: justify;}
    .content p {margin: 10px 0}
    .content .start {text-indent: 5mm;margin-bottom: 0}
    .content label {font-weight: normal;margin-bottom: 0;margin-left: 10mm}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;}
    .content h4 p {margin-left: 25mm;}
    .content h3 {font-size:10pt; line-height: 3mm; text-align: center;font-weight: bold}
    .half-table{width: 50%}
    .half-table tr,
    .half-table td {border: none}
    table {width: 100%; font-size: 10pt;margin: 10px 10px 0 10mm;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding-top: 5px; padding-bottom: 5px;text-align: center;}
    .aleft {text-align: left;padding-left: 5px;}
    .aright {text-align: right;}
    .aleft0 {text-align: left;}
    .footer {margin-top: 10mm;}
    .footer p{font-size: 10pt;line-height: 3mm;float: right}
    .footer table tr td{text-align: center}
    .footer tr,
    .footer td {border: none;padding-top: 5px; padding-bottom: 5px;}
    .footer tr:first-child td{vertical-align: bottom;width: 50%}
    .hr {display: inline-block;}
    .hr:after {content: '';display: block;border-top: 1px solid #000;margin-top:5px;}
    .footer h3 {font-size: 10pt;line-height: 3mm;margin-top: 0;margin-bottom: 5px;}
    @media print
    {
      table { page-break-after:auto }
      tr    { page-break-inside:avoid; page-break-after:auto }
      td    { page-break-inside:avoid; page-break-after:auto }
      thead { display:table-header-group }
      tfoot { display:table-footer-group }
    }
</style>
<body class="legal print-area">
    <section class="sheet padding-10mm">
        <section class="header">
            <img src="{{ asset('logo/'. $instansi->logo) }}" alt="Logo belum diunggah">
            <h4><b>PEMERINTAH
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
                    {{ ' PROVINSI '.strtoupper($instansi->getProvince->province) }}</b></h4>
            <h4><b>{{ strtoupper($instansi->instance) }}</b></h4>
            <h4><b>{{ $instansi->alamat }}</b></h4>
            <h4><b>No.Telp/Fax: {{ $instansi->no_telp }} - {{ $instansi->fax }}</b></h4>
        </section>
        <hr style="border-width: 3px;">
        <hr style="border-width: 1px;">
        <section class="title">
            <h4>BERITA ACARA PEMERIKSAAN PERSEDIAAN<h4>
            <h3>{{ $nomor_berita_acara }}</h3>   
        </section>
        <section class="content">
            <p>Pada Hari ini {{ $tgl_cetak['hari'] }}, Tanggal {{ $tgl_cetak['tanggal'] }} {{ $tgl_cetak['bulan'] }} {{ $tgl_cetak['tahun'] }}, kami yang bertanda  tangan dibawah ini:</p>

            @if(!empty($pengurus_barang))
            <label>
                <h4><span>Nama</span> <p>: &nbsp; {{ $pengurus_barang->nama_berwenang }}</p></h4>
                <h4><span>NIP</span> <p>: &nbsp; {{ $pengurus_barang->nip }}</p></h4>
                <h4><span>Jabatan</span> <p>: &nbsp;
                        @if($pengurus_barang->level==1)
                            Kepala Bidang
                        @elseif($pengurus_barang->level==2)
                            Pengguna Barang
                        @elseif($pengurus_barang->level==3)
                            Pengurus Barang
                        @elseif($pengurus_barang->level==4)
                            Atasan Langsung
                        @elseif($pengurus_barang->level==5)
                            Penyimpan Barang
                        @elseif($pengurus_barang->level==6)
                            Pengguna Anggaran
                        @elseif($pengurus_barang->level==7)
                            Kepala Dinas
                        @elseif($pengurus_barang->level==8)
                            Pejabat Pengadaan
                        @elseif($pengurus_barang->level==9)
                            PPK OPD
                        @endif {{ $instansi->instance }} Prov. {{ $instansi->getProvince->province }}</p></h4>
            </label>
            @else
                <p>Pengurus Barang Belum dimasukan</p>
            @endif
            <p>Telah Melakukan Pemeriksaan Barang Kepada:</p>
             @if(!empty($penyimpan_barang))
            <label>
                <h4><span>Nama</span> <p>: &nbsp; {{ $penyimpan_barang->nama_berwenang }}</p></h4>
                <h4><span>NIP</span> <p>: &nbsp; {{ $penyimpan_barang->nip }}</p></h4>
                <h4><span>Jabatan</span><p>: &nbsp;
                        @if($penyimpan_barang->level==1)
                            Kepala Bidang
                        @elseif($penyimpan_barang->level==2)
                            Pengguna Barang
                        @elseif($penyimpan_barang->level==3)
                            Pengurus Barang
                        @elseif($penyimpan_barang->level==4)
                            Atasan Langsung
                        @elseif($penyimpan_barang->level==5)
                            Penyimpan Barang
                        @elseif($penyimpan_barang->level==6)
                            Pengguna Anggaran
                        @elseif($penyimpan_barang->level==7)
                            Kepala Dinas
                        @elseif($penyimpan_barang->level==8)
                            Pejabat Pengadaan
                        @elseif($penyimpan_barang->level==9)
                            PPK OPD
                        @endif&nbsp; {{ $instansi->instance }} Prov. {{ $instansi->getProvince->province }}</p></h4>
            </label>
            @else
                <p>Pengurus Barang Belum dimasukan</p>
            @endif
            <p>Persediaan barang pakai habis {{ $instansi->instance }} Daerah Provinsi  {{ $instansi->getProvince->province }} tahun {{ $tgl_cetak['tahun_bil'] }} dengan kondisi per {{ $tgl_cetak['tanggal_bil'] }} {{ $tgl_cetak['bulan'] }} {{ $tgl_cetak['tahun_bil'] }}</p>
            <table class="half-table" id="table_penerimaan">
                    <tbody>
                    @php($i=1)
                    @foreach($data['data'] as $datas)
                        <tr>
                            <td>{{ $datas[0] }}.</td>
                            <td class="aleft">{{ $datas[1] }}</td>
                            <td>:</td>
                            <td class="aright">Rp. @if($datas[2]==0) - @else  {{ number_format($datas[2],2,',','.') }}   @endif</td>
                            <td class="aleft0">@if($datas[2]>0)-@endif</td>
                        </tr>
                    @endforeach
                        <tr>
                            <td>&nbsp;</td>
                            <td colspan="3">
                                <hr style="border: solid black; margin: 0px; padding:0px; border-width: 1px">
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td class="aleft">Jumlah</td>
                            <td>:</td>
                            <td class="aright">Rp {{ number_format($data['jumlah_total_stok_opname'],2,',','.') }}</td>
                            <td>@if($data['jumlah_total_stok_opname']>0)-@endif</td>
                        </tr>
                    </tbody>
            </table>
            <p>Demikian Berita Acara Persediaan kami sampaikan untuk bahan penyusunan LKPD Tahun Anggaran  {{ $tgl_cetak['tahun_bil']+1 }}</p>
        </section>
        <section class="footer">
            <p>{{ $instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($tgl_cetak['tanggal_cetak'])) }}</p>
            <table>
                <tr height="35px">
                    <td>
                        @if(!empty($pengurus_barang))
                            @if($pengurus_barang->level==1)
                                Kepala Bidang
                            @elseif($pengurus_barang->level==2)
                                Pengguna Barang
                            @elseif($pengurus_barang->level==3)
                                Pengurus Barang
                            @elseif($pengurus_barang->level==4)
                                Atasan Langsung
                            @elseif($pengurus_barang->level==5)
                                Penyimpan Barang
                            @elseif($pengurus_barang->level==6)
                                Pengguna Anggaran
                            @elseif($pengurus_barang->level==7)
                                Kepala Dinas
                            @elseif($pengurus_barang->level==8)
                                Pejabat Pengadaan
                            @elseif($pengurus_barang->level==9)
                                PPK OPD
                            @endif
                         @else
                            PPK OPD Belum dimasukan
                        @endif
                    </td>
                    <td>
                        @if(!empty($penyimpan_barang))
                            @if($penyimpan_barang->level==1)
                                Kepala Bidang
                            @elseif($penyimpan_barang->level==2)
                                Pengguna Barang
                            @elseif($penyimpan_barang->level==3)
                                Pengurus Barang
                            @elseif($penyimpan_barang->level==4)
                                Atasan Langsung
                            @elseif($penyimpan_barang->level==5)
                                Penyimpan Barang
                            @elseif($penyimpan_barang->level==6)
                                Pengguna Anggaran
                            @elseif($penyimpan_barang->level==7)
                                Kepala Dinas
                            @elseif($penyimpan_barang->level==8)
                                Pejabat Pengadaan
                            @elseif($penyimpan_barang->level==9)
                                PPK OPD
                            @endif
                        @else
                            Penyimpan Barang Belum dimasukan
                        @endif
                    </td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <h3 class="hr">{{ $pengurus_barang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $pengurus_barang->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">{{ $penyimpan_barang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $penyimpan_barang->nip }}</h3>
                    </td>
                </tr>
                @if(!empty($kepala_dinas))
                <tr height="50px" style="vertical-align: bottom">
                    <td colspan="2">
                        @php($jabatass='-')
                        @if(strstr($instansi->instance, "Badan"))
                            Kepala {{ $instansi->instance }}
                        @elseif(strstr($instansi->instance, "Dinas"))
                            Kepala {{ $instansi->instance }}
                        @elseif(strstr($instansi->instance, "Inspektorat"))
                            Inspektur {{ $instansi->instance }}
                        @elseif(strstr($instansi->instance, "Sekretariat"))
                            Sekretaris {{ $instansi->instance }}
                        @endif

                    </td>
                </tr>
                <tr>
                    <td colspan="2">Daerah Provinsi {{ $instansi->getProvince->province }}</td>
                </tr>
                @else
                <tr height="50px" style="vertical-align: bottom">
                    <td colspan="2">
                        Kepala dinas Belum dimasukan
                    </td>
                </tr>
                @endif
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td colspan="2">
                        <h3 class="hr">{{ $kepala_dinas->nama_berwenang }}</h3>
                        <h3>NIP: {{ $kepala_dinas->nip }}</h3>
                    </td>
                </tr>
            </table>
        </section>
    </section>
</body>
<script>
    $(document).ready(function() {
        $('.print-area').print();
    })
</script>
</html>