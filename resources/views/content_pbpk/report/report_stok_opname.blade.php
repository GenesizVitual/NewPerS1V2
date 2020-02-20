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
        <td style="border-color: transparent;" align="center"><H1>LAPORAN STOK OPNAME </H1></td>
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
<table  style="width: 100%;" id="table_penerimaan">
    <thead>

    <tr>
        <td ><strong>No</strong></td>
        <td ><strong>Nama Barang</strong></td>
        <td ><strong>Satuan barang </strong></td>
        <td ><strong>Merek Barang</strong></td>
        <td ><strong>Jumlah Unit </strong></td>
        <td ><strong>Harga Satuan </strong></td>
        <td ><strong>Harga Total</strong></td>
    </tr>
    <tr>
        <td><strong>1</strong></td>
        <td><strong>2</strong></td>
        <td><strong>3</strong></td>
        <td><strong>4</strong></td>
        <td><strong>5</strong></td>
        <td><strong>6</strong></td>
        <td><strong>7</strong></td>
    </tr></thead>

    <tbody>
    @php($i=1)
    @foreach($data as $colum)
        <tr>
            <td>{{ $colum[0] }}</td>
            <td>{{ $colum[1] }}</td>
            <td>{{ $colum[2] }}</td>
            <td>{{ $colum[3] }}</td>
            <td>{{ $colum[4] }}</td>
            <td>{{ $colum[5] }}</td>
            <td class="total">{{ $colum[6] }}</td>
        </tr>
    @endforeach
    <tr>
        <td></td>
        <td colspan="5"><strong>Jumlah Total</strong></td>
        <td id="total_stok"></td>
    </tr>
    </tbody>

</table>
</div>


<div style="padding-top: 3%">
    <table style="width: 100%">
        <tr>
            <td style="border-color: transparent; text-align: left; width: 50%;"></td>
            <td style="border-color: transparent; text-align: left; width: 50%;">
                <p align="center">
                    {{ $instansi->getDistrict->district }}, {{ date('d-M-Y', strtotime($tgl_cetak)) }}
                </p>
            </td>
        </tr>
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
    $(document).ready(function () {
        var total_sekarang = 0;
        var uang_awal = "";
        var uang_akhir = "";
        $('.total').each(function (index) {
            uang_awal = $(this).text().replace('.','');
            uang_akhir = uang_awal.replace(',00','');
            total_sekarang +=parseInt(uang_akhir);
        });
        $('#total_stok').text(format1(total_sekarang,'')+',00');
    })

    function format1(n, currency) {
        return currency + " " + n.toFixed(0).replace(/./g, function(c, i, a) {
            return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
        });
    }

</script>
</html>