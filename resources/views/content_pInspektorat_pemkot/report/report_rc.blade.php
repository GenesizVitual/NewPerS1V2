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
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
</head>
<style>

    #table_penerimaan , td, th {
        border-collapse: collapse;
        border: 1px solid black;
        text-align: center;
    }

    body {
        margin-left: 3%;
    }
</style>
<body>
<table style="width: 100%">
    <tr>
        <td style="border-color: transparent; width: 100px; height: 100px"  ><img src="{{ asset('logo/'. $instansi->logo) }}" alt="Masih di codingkan" style="width: 100%; height:100%;"></td>
        <td style="border-color: transparent;" align="center"><H1>Laporan Rekapitulasi Persediaan <br> Tahun Anggaran: {{ $tahun_anggaran }}</H1></td>
    </tr>

</table>
<div style="padding-top: 3%">
<table>
    <tr>
        <td style="border-color: transparent; text-align: left;" width="100"><strong>SKPD</strong></td>
        <td style="border-color: transparent; text-align: left;" width="20">:</td>
        <td style="border-color: transparent; text-align: left;">{{ $instansi->instance }}</td>
    </tr>
    <tr>
        <td style="border-color: transparent; text-align: left;" ><strong>KOTA/KAB</strong></td>
        <td style="border-color: transparent; text-align: left;">:</td>
        <td style="border-color: transparent; text-align: left;">{{ $instansi->getDistrict->district }}</td>
    </tr>
    <tr>
        <td style="border-color: transparent; text-align: left;" ><strong>PROVINSI</strong></td>
        <td style="border-color: transparent; text-align: left;">:</td>
        <td style="border-color: transparent; text-align: left;">{{ $instansi->getProvince->province }}</td>
    </tr>
</table>
</div>
<div style="padding-top: 3%">

    <table style="width: 100%;" id="table_penerimaan">
        <thead>
        <tr>
            <th>No</th>
            <th>DPA</th>
            <th>Jumlah</th>
        </tr>
        </thead>
        <tbody>
        @php($i=1)
        @if(!empty($listSpj))
            @foreach($listSpj as $spj)
                <tr>
                    <td>{{ $i++ }}</td>
                    <td>{{ $spj->number_spj }}</td>
                    <td> @foreach($totals_spj as $bd)
                            @if($spj->id==$bd->spj_id)
                                Rp. {{ number_format($bd->totalSJP,2,'.','.') }}
                            @endif
                        @endforeach
                    </td>
                </tr>

                @if(!empty($spj->getTbk))
                    @foreach($spj->getTbk as $test)
                        <tr>
                            <td></td>
                            <td>{{ $test->number_tbk }}</td>
                            <td> @if(!empty($test->getSumReciept->sum('totalPrice')) ) Rp. {{ number_format($test->getSumReciept->sum('totalPrice'),2,'.','.') }} @endif
                            </td>
                        </tr>
                    @endforeach
                @endif

            @endforeach
        @endif
        <tr>
            <th colspan="2">Sisa DPA</th>
            <th>
                @if(!empty($dpa->pagu_value))
                    Rp {{ number_format($dpa->pagu_value-$jumlah_spj,2,'.','.') }}
                @else
                    Rp {{ number_format(0,2,'.','.') }}
                @endif
            </th>
        </tr>
        </tbody>
    </table>
</div>


<div style="padding-top: 3%">
    <table style="width: 100%">
        {{--<tr>--}}
            {{--<td style="border-color: transparent; text-align: left; width: 50%;"></td>--}}
            {{--<td style="border-color: transparent; text-align: left; width: 50%;">--}}
                {{--<p align="center">--}}
                    {{--{{ $instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime()) }}--}}
                {{--</p>--}}
            {{--</td>--}}
        {{--</tr>--}}
        <tr>
            <td style="border-color: transparent; text-align: left; width: 50%;">
                @if(!empty($atasan_langsung))
                    <p>
                    <p align="center"><strong>Atasan Langsung</strong></p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p align="center"><u><strong>{{ $atasan_langsung->nama_berwenang }}</strong></u><br>NIP: {{ $atasan_langsung->nip }}
                    </p>
                    </p>
                @else
                    Atasan langsung Belum dimasukan
                @endif
            </td>
            <td style="border-color: transparent; text-align: left; width: 50%;">
                @if(!empty($penyimpan_barang))
                    <p>
                    <p align="center"><strong>Penyimpan Barang</strong></p>
                    <br>
                    <br>
                    <br>
                    <br>
                    <br>
                    <p align="center"><u><strong>{{ $penyimpan_barang->nama_berwenang }}</strong></u><br>NIP: {{ $penyimpan_barang->nip }}
                    </p>
                    </p>
                @else
                    Penyimpan Barang Belum dimasukan
                @endif
            </td>
        </tr>
    </table>
</div>
</body>
<script>

</script>
</html>