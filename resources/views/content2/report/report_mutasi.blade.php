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
    <style>@page { size: legal landscape}</style>
</head>
<style>
    .header img { width: 100px;float:left; margin-top: -3mm;vertical-align: middle;}
    .header h2  { font-size: 20pt; line-height: 3mm; text-align:center;padding-top:3mm;font-weight: bold}
    .header h1  { font-size: 20pt; line-height: 3mm; text-align:center;margin: 0;padding-top: 10mm;font-weight: bold}
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

<body class="legal landscape print-area">
    <section class="sheet padding-10mm">
        <section class="header">
            <img src="{{ asset('logo/'. $instansi->logo) }}" alt="Logo belum diunggah">
            @if($bulan!="")
                <h2>LAPORAN MUTASI PERSEDIAAN BARANG</h2>
                <h2>BULAN {{ $bulan }} {{ $thn_anggaran }}</h2>
            @else
                <h1>LAPORAN MUTASI PERSEDIAAN BARANG</h1>
            @endif
        </section>
        <section class="content">
            <label>
                <h4><span>SKPD</span> <p>: &nbsp; {{ $instansi->instance }}</p></h4>
                <h4><span>KOTA/KAB</span> <p>: &nbsp; {{ $instansi->getDistrict->district }}</p></h4>
                <h4><span>PROVINSI</span> <p>: &nbsp; {{ $instansi->getProvince->province }}</p></h4>
            </label>
            <table id="example1" class="custom_table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">&nbsp;&nbsp;Tanggal&nbsp;&nbsp;</th>
                        <th rowspan="2">Uraian</th>
                        <th colspan="3">Saldo</th>
                        <th colspan="6">mutasi</th>
                        <th colspan="2">Saldo Akhir</th>
                    </tr>
                    <tr>
                        <th>Jumlah</th>
                        <th>Satuan</th>
                        <th>Total</th>
                        <th>Penerimaan</th>
                        <th>Harga Beli</th>
                        <th>Total Penerimaan</th>
                        <th>Pengeluaran</th>
                        <th>Harga Beli</th>
                        <th>Total Pengeluaran</th>
                        <th>Sisa Barang </th>
                        <th>Jumlah Akhir </th>
                    </tr>
                </thead>
                <tbody>
                @php($i=1)
                @foreach($data as $colum)
                    <tr>
                        <td class="rows"></td>
                        <td><p style="color: white; font-size: 1px; text-align: left">{{ date('Y-m-d',strtotime($colum[1])) }}</p> {{ $colum[1] }} <p></p></td>
                        <td class="aleft">{{ $colum[2] }}</td>
                        <td>{{ $colum[3] }}</td>
                        <td>{{ $colum[4] }}</td>
                        <td class="aright">{{ $colum[5] }}</td>
                        <td>{{ $colum[6] }}</td>
                        <td class="aright">{{ $colum[7] }}</td>
                        <td class="aright">{{ $colum[8] }}</td>
                        <td>{{ $colum[9] }}</td>
                        <td class="aright">{{ $colum[10] }}</td>
                        <td class="aright">{{ $colum[11] }}</td>
                        <td>{{ $colum[12] }}</td>
                        <td class="aright">{{ $colum[13] }}</td>
                    </tr>
                @endforeach
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

        }

        make_serial_number();

        $('.print-area').print();
    } );
</script>
</html>