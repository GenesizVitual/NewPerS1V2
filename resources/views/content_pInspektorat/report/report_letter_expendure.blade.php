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
        <td style="border-color: transparent;" align="center">
            <H4>{{ $instansi->instance }}
                @switch($instansi->tingkat)
                    @case('1')
                    Daerah Provinsi
                    @break
                    @case('2')
                    Kota {{ $instansi->getDistrict->district }}
                    @break
                    @case('3')
                    Kabupaten {{ $instansi->getDistrict->district }}
                    @break
                    @default
                    <label style="color: red;"> anda belum memilih tingkatan pada instansi </label>
                @endswitch
            </H4>
            <H4>Provinsi {{ $instansi->getProvince->province }}</H4>
            <H4>{{ $instansi->alamat }}</H4>
            <H4>No.Telp/Fax: {{ $instansi->no_telp }} - {{ $instansi->fax }}</H4>
        </td>
    </tr>
</table>
<hr>
<p align="center"><strong>Surat Pengeluaran Barang</strong></p>
<div style="padding-top: 3%">

    <table>

        <tr>
            <td style="border-color: transparent; text-align: left;" width="150"><strong> Nomor </strong></td>
            <td style="border-color: transparent; text-align: left;" width="20">:</td>
            <td style="border-color: transparent; text-align: left;">{{ $surat_pengeluaran->no_surat_pengeluaran }}</td>
        </tr>
        <tr>
            <td style="border-color: transparent; text-align: left;" ><strong>Bidang</strong></td>
            <td style="border-color: transparent; text-align: left;">:</td>
            <td style="border-color: transparent; text-align: left;">{{ $surat_pengeluaran->getSector->sector_name }}</td>
        </tr>
        <tr>
            <td style="border-color: transparent; text-align: left;" ><strong>Perihal</strong></td>
            <td style="border-color: transparent; text-align: left;">:</td>
            <td style="border-color: transparent; text-align: left;">{{ $surat_pengeluaran->prihal }}</td>
        </tr>
        {{--<tr>--}}
            {{--<td style="border-color: transparent; text-align: left;" >Ditujukan</td>--}}
            {{--<td style="border-color: transparent; text-align: left;">:</td>--}}
            {{--<td style="border-color: transparent; text-align: left;">{{ $surat_pengeluaran->get_tujukan->nama_berwenang }}</td>--}}
        {{--</tr>--}}
    </table>
</div>
<div style="padding-top: 3%">

    <p style="font-size: medium">{{ $surat_pengeluaran->isi_surat }}</p>
    <table  style="width: 100%;" id="table_penerimaan">
        <thead>
        <tr>
            <td >No</td>
            {{--<td >Nama Bidang</td>--}}
            <td >Nama Barang </td>
            <td >Unit</td>
            <td >Jumlah Barang</td>
            {{--<td >Tanggal Keluar</td>--}}
        </tr>
       </thead>

        <tbody>
        @php($i=1)
        @foreach($data as $colum)
            <tr>
                <td>{{ $colum[0] }}</td>
                <td>{{ $colum[1] }}</td>
                <td>{{ $colum[2] }}</td>
                <td>{{ $colum[3] }}</td>
                {{--<td>{{ $colum[4] }}</td>--}}

            </tr>
        @endforeach
        </tbody>

    </table>
    <p style="font-size: medium">{{ $surat_pengeluaran->penutup_surat }}</p>
    <p style="font-size: medium; padding-top: 10px; padding-right: 15%" align="right">{{ $instansi->getDistrict->district }},{{ date('d-m-Y', strtotime($surat_pengeluaran->tgl_cetak)) }}</p>
</div>
<div style="padding-top: 3%">
    <table style="width: 100%">
        <tr>
            <td style="border-color: transparent; text-align: left; width: 50%;">
                @if(!empty($surat_pengeluaran))
                <p><p align="center"><strong>Penyimpan Barang</strong></p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <p align="center"><u>(<strong>{{ $penyimpan_barangs->nama_berwenang }}</strong>)</u><br>{{ $penyimpan_barangs->nip }}
                </p>
                </p>
                @else
                    <p>Kepala bidang Belum dimasukan</p>
                @endif
            </td>
            <td style="border-color: transparent; text-align: left; width: 50%;">
                @if(!empty($surat_pengeluaran))
                <p>
                <p align="center"><strong>Pengguna Barang</strong></p>
                <br>
                <br>
                <br>
                <br>
                <br>
                <p align="center"><u>(<strong>{{ $surat_pengeluaran->get_pengguna_barang->nama_berwenang }}</strong>)</u><br>NIP: {{ $surat_pengeluaran->get_pengguna_barang->nip }}
                </p>
                </p>
                @else
                    <p>Pengguna Barang belum dimasukan</p>
                @endif
            </td>
        </tr>
    </table>
</div>
</body>
<script>

</script>
</html>