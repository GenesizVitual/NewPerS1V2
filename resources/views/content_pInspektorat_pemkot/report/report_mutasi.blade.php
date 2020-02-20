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
        <td style="border-color: transparent;" align="center"><H1>LAPORAN MUTASI PERSEDIAAN BARANG </H1></td>
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
<table  style="width: 100%;" id="example1" class="custom_table">
    <thead>
    <tr>
        <td rowspan="2"><div align="center"><strong>No</strong></div></td>
        <td rowspan="2"><div align="center"><strong>Tanggal</strong></div></td>
        <td rowspan="2"><div align="center"><strong>Uraian</strong></div></td>
        <td colspan="3"><div align="center"><strong>Saldo</strong></div></td>
        <td colspan="6"><div align="center"><strong>mutasi</strong></div></td>
        <td colspan="2"><div align="center"><strong>Saldo Akhir</strong> </div></td>
    </tr>
    <tr>
        <td><div align="center"><strong>Jumlah</strong></div></td>
        <td><div align="center"><strong>Satuan</strong></div></td>
        <td><div align="center"><strong>Total</strong></div></td>
        <td><div align="center"><strong>Penerimaan</strong></div></td>
        <td><div align="center"><strong>Harga Beli </strong></div></td>
        <td><div align="center"><strong>Total Penerimaan</strong> </div></td>
        <td><div align="center"><strong>Pengeluaran</strong></div></td>
        <td><div align="center"><strong>Harga Beli </strong></div></td>
        <td><div align="center"><strong>Total Pengeluaran </strong></div></td>
        <td><div align="center"><strong>Sisa Barang </strong></div></td>
        <td><div align="center"><strong>Jumlah Akhir </strong></div></td>
    </tr>
    </thead>

    <tbody>
    @php($i=1)
    @foreach($data as $colum)
        <tr>
            <td class="rows"></td>
            <td>{{ $colum[1] }}</td>
            <td>{{ $colum[2] }}</td>
            <td>{{ $colum[3] }}</td>
            <td>{{ $colum[4] }}</td>
            <td>{{ $colum[5] }}</td>
            <td>{{ $colum[6] }}</td>
            <td>{{ $colum[7] }}</td>
            <td>{{ $colum[8] }}</td>
            <td>{{ $colum[9] }}</td>
            <td>{{ $colum[10] }}</td>
            <td>{{ $colum[11] }}</td>
            <td>{{ $colum[12] }}</td>
            <td>{{ $colum[13] }}</td>
        </tr>
    @endforeach
    </tbody>

</table>
</div>


<div style="padding-top: 3%">
    <table style="width: 100%">
        <tr>
            <td style="border-color: transparent; text-align: left; width: 50%;"></td>
            <td style="border-color: transparent; text-align: left; width: 50%;">
                <p align="center">
                    {{ $instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($tgl_cetak)) }}
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
<!-- DataTables -->
<script src="{{ asset('assets2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script>
    $(document).ready(function() {
        var table=$('#example1').DataTable({
            'paging'      : false,
            ordering:true,
            'searching'   : false,
            info: false,
            processing:true,
            retrieve : true
        });


        make_serial_number=function(){
            table.order([ 1, 'asc' ]).draw()
            $('.rows').each(function(idx, element){
                console.log(idx);
                $(this).text(idx+1);
            });

        }

        make_serial_number();



    } );
</script>
</html>