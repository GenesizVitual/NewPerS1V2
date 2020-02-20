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
<style type="text/css">
    .header img { width: 100px;float:left; margin-top: -3mm;vertical-align: middle;}
    .header h2  { font-size: 20pt; line-height: 3mm; text-align:center;margin-bottom: 12px;font-weight: bold}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 15mm;text-align: justify;}
    .content label {font-weight: normal;margin-bottom: 0}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;font-weight: bold}
    .content h4 p {margin-left: 35mm;}
    .content h3 {font-size:10pt; line-height: 3mm; text-align: center;font-weight: bold}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding:5px 2px;text-align: center;}
    th {line-height: 5mm}
    .break-all{ word-break: break-all;min-width: 50px;}
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
            <h2>LAPORAN SEMESTER</h2>
            <h2>TENTANG PENERIMAAN DAN PENGELUARAN BARANG PAKAI HABIS</h2>
            <h2>SEMESTER {{ $sms }} TAHUN {{ $tahun_anggaran }}</h2>
        </section>
        <section class="content">
            <label>
                <h4><span>SKPD</span> <p>: &nbsp; {{ $instansi->instance }}</p></h4>
                <h4><span>KOTA/KAB</span> <p>: &nbsp; {{ $instansi->getDistrict->district }}</p></h4>
                <h4><span>PROVINSI</span> <p>: &nbsp; {{ $instansi->getProvince->province }}</p></h4>
            </label>
            <table  style="width: 100%;" id="example1">
                <thead>
                    <tr>
                        <th rowspan="3">No</th>
                        <th rowspan="3">Tgl Terima  </th>
                        <th rowspan="3">Dari</th>
                        <th colspan="2">Dokumen Faktur </th>
                        <th colspan="2">&nbsp;</th>
                        <th rowspan="3">Banyaknya</th>
                        <th rowspan="3">Nama<br>Barang </th>
                        <th rowspan="3">Harga<br>Satuan<br>(Rp) </th>
                        <th colspan="2">Bukti Penerimaan </th>
                        <th rowspan="3">Ket</th>
                        <th rowspan="3">No.Urut </th>
                        <th rowspan="3" class="break-all">Tanggal<br>Pengeluaran </th>
                        <th colspan="2">Surat Bon</th>
                        <th rowspan="3">Untuk</th>
                        <th rowspan="3">Banyaknya</th>
                        <th rowspan="3">Nama Barang </th>
                        <th rowspan="3">Harga<br>satuan<br>(Rp)</th>
                        <th rowspan="3">Jumlah<br>Harga<br>(Rp)</th>
                        <th rowspan="3" class="break-all">Tanggal<br>Penyerahan</th>
                        <th rowspan="3">Ket</th>
                    </tr>
                    <tr>
                        <th rowspan="2">No.</th>
                        <th rowspan="2">Tgl</th>
                        <th rowspan="2">Jenis surat </th>
                        <th rowspan="2">No.</th>
                        <th colspan="2">B.A./Srt.Penerimaan </th>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Tgl</th>
                    </tr>
                    <tr>
                        <th >No.</th>
                        <th >Tgl</th>
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
                        <td class="rows"></td>
                        <td><p style="color: white; font-size: 1px; text-align: left">{{ date('Y-m-d',strtotime($colum[1])) }}</p> {{ $colum[1] }}<p></p></td>
                        <td class="aleft">{{ $colum[2] }}</td>
                        <td>{{ $colum[3] }}</td>
                        <td>{{ $colum[4] }}</td>
                        <td>{{ $colum[5] }}</td>
                        <td>{{ $colum[6] }}</td>
                        <td>{{ $colum[7] }}</td>
                        <td class="aleft">{{ $colum[8] }}</td>
                        <td class="aright">{{ $colum[9] }}</td>
                        <td>{{ $colum[10] }}</td>
                        <td>{{ $colum[11] }}</td>
                        <td class="aleft">{{ $colum[12] }}</td>
                        <td class="rows1"></td>
                        <td>{{ $colum[14] }}</td>
                        <td>{{ $colum[15] }}</td>
                        <td>{{ $colum[16] }}</td>
                        <td>{{ $colum[17] }}</td>
                        <td>{{ $colum[18] }}</td>
                        <td class="aleft">{{ $colum[19] }}</td>
                        <td class="aright">{{ $colum[20] }}</td>
                        <td class="aright">{{ $colum[21] }}</td>
                        <td>{{ $colum[22] }}</td>
                        <td class="aleft">{{ $colum[23] }}</td>
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
		//$('.print-area').print();
        var table=$('#example1').DataTable({
            'paging'      : false,
           // ordering:true,
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
            $('.rows1').each(function(idx, element){
                console.log(idx);
                $(this).text(idx+1);
            });
//
        }

        make_serial_number();

      //  setTimeout(function(){  $('.print-area').print(); }, 8000);

    });

</script>
</html>