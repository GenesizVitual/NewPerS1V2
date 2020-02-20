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
        <td style="border-color: transparent;" align="center"><H1>BUKU PENGELUARAN BARANG </H1></td>
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
        <th>No</th>
        <th>Tanggal keluar</th>
        <th>No Urut</th>
        <th>Nama Barang</th>
        <th>Banyaknya</th>
        <th>Harga Satuan(Rp)</th>
        <th>Jumlah Harga (Rp)</th>
        <th>Untuk</th>
        <th>Tanggal Penyerahan</th>
        <th>Keterangan</th>
    </tr>
    <tr>
        <th>1</th>
        <th>2</th>
        <th>3</th>
        <th>4</th>
        <th>5</th>
        <th>6</th>
        <th>7</th>
        <th>8</th>
        <th>9</th>
        <th>10</th>
    </tr>
    </thead>

    <tbody>
    @php($i=1)
    @foreach($data as $colum)
        <tr>
            <td class="rows"></td>
            <td><span style="display: none"> {{ date('Y-m-d', strtotime($colum[1] )) }}</span>{{ $colum[1] }}</td>
            <td class="rows2"></td>
            <td>{{ $colum[3] }}</td>
            <td>{{ $colum[4] }}</td>
            <td>{{ $colum[5] }}</td>
            <td>{{ $colum[6] }}</td>
            <td>{{ $colum[7] }}</td>
            <td>{{ $colum[8] }}</td>
            <td>{{ $colum[9] }}</td>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
<script src="{{ asset('assets2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
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
            $('.row2').each(function(idx, element){
                console.log(idx);
                $(this).text(idx+1);
            });

        }

        make_serial_number();


    } );
</script>
</html>