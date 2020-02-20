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
    <style>@page { size: legal landscape}</style>
</head>
<style>
    .header img { width: 90px;float:left; margin-top: -3mm}
    .header h4  { font-size: 11pt; line-height: 3mm; text-align:center;}
    hr {border-color: black; margin: 5px 0;}
    .title {margin-top: 10mm;text-align: center;}
    .title h4 {font-size: 11pt; line-height: 3mm; font-weight: bold;}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 5mm;text-align: justify;}
    .content label {font-weight: normal;margin-bottom: 0}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;font-weight: bold}
    .content h4 p {margin-left: 35mm;}
    .content h3 {font-size:10pt; line-height: 3mm; text-align: center;font-weight: bold}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding: 5px;text-align: center;}
    .aleft {text-align: left;padding-left: 5px;}
    .aleft10{text-align: left;padding-left: 10px;}
    .aleft15{text-align: left;padding-left: 15px;}
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
<body class="legal landscape print-area">
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
            <h4>LAPORAN REALISASI ANGGARAN PERSEDIAAN BARANG PAKAI HABIS</h4>
        </section>
        <section class="content">
            <table>
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode Rekening</th>
                        <th>Uraian</th>
                        <th>Jumlah</th>
                        <th>Digunakan</th>
                        <th>Sisa</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($data['data'] as $datas)
                    <tr>
                        <td>{{ $datas[0] }}</td>
                        {!! $datas[1]  !!}
                        <td class="aleft">{{ $datas[2] }}   </td>
                        <td class="aright">{{ $datas[3] }}</td>
                        <td class="aright">{{ $datas[4] }}</td>
                        <td class="aright">{{ $datas[5] }}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="3"><b>Jumlah</b></td>
                    <td class="aright">{{ number_format($data['jumlah_belanja']->jumlah_anggaran,2,',','.') }}</td>
                    <td class="aright">{{ number_format($data['jumlah_belanja_yang_dipakai']->jumlah_pemakaian_anggaran,2,',','.') }}</td>
                    <td class="aright">{{ number_format($data['jumlah_belanja']->jumlah_anggaran-$data['jumlah_belanja_yang_dipakai']->jumlah_pemakaian_anggaran,2,',','.') }}</td>
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
</body>
<!-- DataTables -->
<script src="{{ asset('assets2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>
<script src="{{ asset('assets2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        table_rincian = $('#table_rincian_barang').DataTable({
            data:[],
            column:[
                {'data' :'0'},
                {'data' :'1'},
                {'data' :'2'},
                {'data' :'3'},
                {'data' :'4'},
                {'data' :'5'},
            ],
            rowCallback : function(row, data){

            },
            filter: false,
            paging : false,
            searching: false,
            info : false,
            ordering : false,
            processing : true,
            retrieve: true
        });

        $('.print-area').print();
    })
</script>
</html>