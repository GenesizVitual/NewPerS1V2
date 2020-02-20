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
        <td style="border-color: transparent;" align="center"><H3>LAPORAN SEMESTER <br> TENTANG PENERIMAAN DAN PENGELUARAN BARANG PAKAI HABIS <br>
            SEMESTER
            @if($sms==1)
                I
            @elseif($sms==2)
                II
                @elseif($sms==3)
                III
                @elseif($sms==4)
                IV
                @endif
                TAHUN {{ $tahun_anggaran }}</H3></td>
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
        <th rowspan="3">No</th>
        <th rowspan="3">Terima Tanggal </th>
        <th rowspan="3">Dari</th>
        <th colspan="2">Dokumen Faktur </th>
        <th colspan="2">&nbsp;</th>
        <th rowspan="3">Banyak</th>
        <th rowspan="3">Nama Barang </th>
        <th rowspan="3">Harga Satuan (Rp) </th>
        <th colspan="2">Bukti Penerimaan </th>
        <th rowspan="3">Ket</th>
        <th rowspan="3">No. Urut </th>
        <th rowspan="3">Tanggal Pengeluaran </th>
        <th colspan="2">Surat Bon </th>
        <th rowspan="3">Untuk</th>
        <th rowspan="3">Banyaknya</th>
        <th rowspan="3">Nama Barang </th>
        <th rowspan="3">Harga satuan (Rp) </th>
        <th rowspan="3">Jumlah Harga (Rp) </th>
        <th rowspan="3">Tanggal Penyerahan </th>
        <th rowspan="3">Ket</th>
    </tr>
    <tr>
        <th rowspan="2">No.</th>
        <th rowspan="2">Tanggal.</th>
        <th rowspan="2">Jenis surat </th>
        <th rowspan="2">Nomor</th>
        <th colspan="2">B.A./Srt. Penerimaan </th>
        <th rowspan="2">No</th>
        <th rowspan="2">Tgl</th>
    </tr>
    <tr>
        <th >Nomor</th>
        <th >Tanggal</th>
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
        <th>11</th>
        <th>12</th>
        <th>13</th>
        <th>14</th>
        <th>15</th>
        <th>16</th>
        <th>17</th>
        <th>18</th>
        <th>19</th>
        <th>20</th>
        <th>21</th>
        <th>22</th>
        <th>23</th>
        <th>24</th>
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
            <td>{{ $colum[14] }}</td>
            <td>{{ $colum[15] }}</td>
            <td>{{ $colum[16] }}</td>
            <td>{{ $colum[17] }}</td>
            <td>{{ $colum[18] }}</td>
            <td>{{ $colum[19] }}</td>
            <td>{{ $colum[20] }}</td>
            <td>{{ $colum[21] }}</td>
            <td>{{ $colum[22] }}</td>
            <td>{{ $colum[23] }}</td>
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
<script>

</script>
</html>