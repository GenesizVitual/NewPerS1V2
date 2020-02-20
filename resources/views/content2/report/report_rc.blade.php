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
    .header img { width: 100px;float:left; margin-top: -3mm;vertical-align: middle;}
    .header h2  { font-size: 20pt; line-height: 3mm; text-align:center;padding-top:3mm;font-weight: bold}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 15mm;text-align: justify;}
    .content label {font-weight: normal;margin-bottom: 0}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;font-weight: bold}
    .content h4 p {margin-left: 35mm;}
    .content h3 {font-size:10pt; line-height: 3mm; text-align: center;font-weight: bold}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding: 5px;text-align: center;}
    .aleft {text-align: left;padding-left: 5px;}
    .aright {text-align: right;padding-right:5px;}
    .line-break{word-break: break-all}
    .footer {margin-top: 10mm;}
    .footer p{font-size: 10pt;line-height: 3mm;float: right}
    .footer table tr td{text-align: center}
    .footer tr,
    .footer td {border: none}
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
<body>
    <body class="legal print-area">
    <section class="sheet padding-10mm">
        <section class="header">
            <img src="{{ asset('logo/'. $instansi->logo) }}" alt="Logo belum diunggah">
            <h2>LAPORAN REKAPITULASI PERSEDIAAN</h2>
            <h2>TAHUN ANGGARAN: {{ $tahun_anggaran }}</h2>
        </section>
        <section class="content">
            <label>
                <h4><span>SKPD</span> <p>: &nbsp; {{ $instansi->instance }}</p></h4>
                <h4><span>KOTA/KAB</span> <p>: &nbsp; {{ $instansi->getDistrict->district }}</p></h4>
                <h4><span>PROVINSI</span> <p>: &nbsp; {{ $instansi->getProvince->province }}</p></h4>
            </label>
            <table id="table_penerimaan">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>DPA</th>
                        <th>Jumlah (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                @php($i=1)
                @if(!empty($listSpj))
                    @foreach($listSpj as $spj)
                        <tr>
                            <td rowspan="{{count($spj->getTbk)+1}}">{{ $i++ }}</td>
                            <td class="aleft">{{ $spj->number_spj }}</td>
                            <td class="aright">
                                @if(!empty($spj->getTbk))
                                    @php($total_spj=0)
                                    @foreach($spj->getTbk as $test)

                                        @if(!empty($test->getSumReciept->sum('totalPrice')) )
                                            @php($total_spj+=$test->getSumReciept->sum('totalPrice'))
                                        @endif
                                    @endforeach
                                    Rp. {{ number_format($total_spj,2,',','.') }}
                                @endif
                            </td>
                        </tr>

                        @if(!empty($spj->getTbk))
                            @foreach($spj->getTbk as $test)
                                <tr>
                                    <td class="aleft">&nbsp;&nbsp;{{ $test->number_tbk }}</td>
                                    <td class="aright"> @if(!empty($test->getSumReciept->sum('totalPrice')) ) {{ number_format($test->getSumReciept->sum('totalPrice'),2,'.','.') }} @endif
                                    </td>
                                </tr>
                            @endforeach
                        @endif

                    @endforeach
                @endif
                <tr>
                    <th colspan="2" class="aleft">Jumlah DPA</th>
                    <th class="aright">
                        @if(!empty($dpa->pagu_value))
                            Rp {{ number_format($dpa->pagu_value,2,'.','.') }}
                        @else
                            Rp {{ number_format(0,2,'.','.') }}
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="2" class="aleft">Jumlah Yang Terpakai</th>
                    <th class="aright">
                        @if(!empty($jumlah_spj))
                            Rp {{ number_format($jumlah_spj,2,'.','.') }}
                        @else
                            Rp {{ number_format(0,2,'.','.') }}
                        @endif
                    </th>
                </tr>
                <tr>
                    <th colspan="2" class="aleft">Sisa DPA</th>
                    <th class="aright">
                        @if(!empty($dpa->pagu_value))
                            Rp {{ number_format($dpa->pagu_value-$jumlah_spj,2,'.','.') }}
                        @else
                            Rp {{ number_format(0,2,'.','.') }}
                        @endif
                    </th>
                </tr>
                </tbody>
            </table>
        </section>
        <section class="footer">
            <p>{{ $instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($tgl_cetak)) }}</p>
            <table>
                <tr height="35px">
                    <td>
                        @if(!empty($atasan_langsung))
                            Atasan Langsung
                        @else
                            Atasan langsung Belum dimasukan
                        @endif
                    </td>
                    <td>
                        @if(!empty($penyimpan_barang))
                            Pengurus Barang
                        @else
                            Pengurus Barang Belum dimasukan
                        @endif
                    </td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <h3 class="hr">{{ $atasan_langsung->nama_berwenang }}</h3>
                        <h3>NIP. {{ $atasan_langsung->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">{{ $penyimpan_barang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $penyimpan_barang->nip }}</h3>
                    </td>
                </tr>
            </table>
        </section>
    </section>
<script>
    $(document).ready(function() {
        $('.print-area').print();
    });
</script>
</html>