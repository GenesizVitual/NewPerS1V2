<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <!-- jQuery 3 -->
    <script type="text/javascript" src="{{ asset('assets2/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets2/bower_components/paper/jQuery.print.js') }}"></script>
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/paper/paper.css') }}">
    <style>@page { size: legal }</style>
</head>
<style type="text/css">
    .header img { width: 90px;float:left; margin-top: -3mm}
    .header h4  { font-size: 11pt; line-height: 3mm; text-align:center;}
    hr {border-color: black; margin: 5px 0;}
    .title {margin-top: 10mm;}
    .title h4 {font-size: 11pt; line-height: 3mm; text-align: center;font-weight: bold;}
    .nomor-surat {margin: 10mm 0 5mm;}
    .nomor-surat h4{font-size: 10pt; line-height: 3mm;}
    .nomor-surat b {float:left;}
    .nomor-surat p {margin-left: 30mm;}
    .content {margin-top: 8mm;}
    .content h5 {font-size: 10pt;line-height: 3mm;margin-left: 10mm}
    .content h4 {font-size: 10pt;line-height: 3mm;}
    .content span {float:left;}
    .content p {margin-left: 20mm;}
    .content h3 {font-size: 10pt;line-height: 3mm;margin-top: 10px}
    .content h6 {font-size: 10pt;line-height: 3mm;}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding:5px;}
    th {text-align: center;}
    tbody tr td:first-child,
    tbody tr td:nth-child(3),
    tbody tr td:nth-child(4) {text-align: center;}
    tbody tr td:nth-child(2) {text-align: left;padding-left: 5px}
    tbody tr td:nth-child(5),
    tbody tr td:nth-child(6) {text-align: right; padding-right: 5px;}
    .indent {padding-left: 5px;}
    .right {text-align: right;padding-right: 5px;}
    ol {padding:0;margin-left:4mm;}
    ol li {font-size: 10pt;line-height: 6mm;}
    ol li p {margin-left: 0!important;margin-bottom: 0!important}
    .footer {margin-top: 10mm;}
    .footer p{font-size: 10pt;line-height: 3mm;float: right}
    .footer table tr td{text-align: center}
    .footer tr,
    .footer td {border: none}
    .footer tr:first-child td{vertical-align: bottom;width: 50%}
    .hr {display: inline-block;}
    .hr:after {content: '';display: block;border-top: 1px solid #000;margin-top:5px;}
    .footer h3 {font-size: 10pt;line-height: 3mm;margin-top: 0;margin-bottom: 5px;}
</style>
<body class="legal print-area">
    <section class="sheet padding-10mm">
        <section class="header">
            <img src="{{ asset('logo/'. $instansi->logo) }}" alt="Logo belum diunggah">
            @php($tingkat="")
            @switch($instansi->tingkat)
                @case('1')
                {{--//Provinsi--}}
                @php($tingkat="Provinsi")
                @break
                @case('2')
                {{--Kota {{ $instansi->getDistrict->district }}--}}
                @php($tingkat="Kota")
                @break
                @case('3')
                {{--Kabupaten {{ $instansi->getDistrict->district }}--}}
                @php($tingkat="Kabupaten")
                @break
                @default
                <label style="color: red;"> anda belum memilih tingkatan pada instansi </label>
            @endswitch
            @php($instansi_baru= str_replace($tingkat.' '.$instansi->getProvince->province,'',$instansi->instance))
            <H4>{{ strtoupper($instansi_baru) }}</H4>
            <h4>PROVINSI {{ strtoupper($instansi->getProvince->province) }}</h4>
            <h4>{{ $instansi->alamat }}</h4>
            <h4>No.Telp/Fax: {{ $instansi->no_telp }} - {{ $instansi->fax }}</h4>
        </section>
        <hr style="border-width: 3px;">
        <hr style="border-width: 1px;">
        <section class="title">
            <h4><u>SURAT PESANAN</u></h4>
            <h4>(PERMINTAAN PEMBELIAN)</h4>   
        </section>
        <section class="nomor-surat">
            <h4><b>Nomor</b><p>: &nbsp;{{ $nota_pesanan->nomor_surat }}</p></h4>
            <h4><b>Paket Pekerjaan</b> <p>: &nbsp;{{ $nota_pesanan->get_belanja->name_belanja }}</p></h4>       
        </section>
        <section class="content">
            <h5>Yang Bertanda tangan dibawah ini :</h5>
            <h4><span>Nama</span> <p>: &nbsp; {{ $nota_pesanan->get_berwenang->nama_berwenang }}</p></h4>
            <h4><span>Alamat</span> <p>: &nbsp; {{ $nota_pesanan->get_instansi->alamat }}</p></h4>
            <h4><span>Jabatan</span> <p>: &nbsp; @if($nota_pesanan->get_berwenang->level==6)
                            Kuasa Pengguna Anggaran
                        @elseif($nota_pesanan->get_berwenang->level==7)
                            Panitia penyenggara kegiatan
                        @endif</p>
            </h4>
            <h3>Dalam Hal ini mewakili Pengguna Barang/Jasa pada Satker .......... Selanjutnya disebut: <b>@if($nota_pesanan->get_berwenang->level==6)
                    Kuasa Pengguna Anggaran
                @elseif($nota_pesanan->get_berwenang->level==7)
                    Panitia penyenggara kegiatan
                @endif
                </b>
            </h3>
            <h5>Dengan ini memerintahkan : </h5>
            <h4><span>Nama</span> <p>: &nbsp; {{ $nota_pesanan->get_supplier->suppliers }}</p></h4>
            <h4><span>Alamat</span> <p>: &nbsp; {{ $nota_pesanan->get_supplier->alamat }}</p></h4>
            <h3>Yang Dalam Hal ini diwakili oleh : &nbsp;{{$nota_pesanan->get_supplier->pimpinan }} selanjutnya disebut sebagai penyedia</h3>
            <h3>Untuk mengirimkan barang dengan memperhatikan ketentuan-ketentuan sebagai berikut:</h3>
            <ol>
                <li>Rincian Barang
                    <table id="table_rincian_barang">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Barang</th>
                            <th>Kuantitas</th>
                            <th>Satuan</th>
                            <th>Harga Satuan (Rp.)</th>
                            <th>Jumlah Harga (Rp.)</th>
                        </tr>
                        </thead>
                        <tbody></tbody>
                        <tfoot>
                            <tr>
                                <td colspan="5" class="indent">Jumlah Harga (Termasuk Pajak)</td>
                                <td class="right" id="jumlah_harga-barang">...</td>
                            </tr>
                            <tr>
                                <td colspan="6" class="indent">Terbilang : <b id="terbilang_harga_barang"></b></td>
                            </tr>
                        </tfoot>
                    </table>
                </li>
                <li>Tanggal Barang Diterima : {{ date('d-m-Y', strtotime($nota_pesanan->tanggal_selesai_pekerjaan)) }}</li>
                <li>Syarat-syarat pekerjaan :
                    <p>{!!   $nota_pesanan->syarat_syarat_pekerjaan !!}</p>
                </li>
                <li>Waktu penyelesaian : {{ date('d-m-Y', strtotime($nota_pesanan->tgl_awal_pekerjaan)) }} - {{ date('d-m-Y', strtotime($nota_pesanan->tanggal_selesai_pekerjaan)) }}</li>
                <li>Tempat pelaksanaan pekerjaan : {{ $nota_pesanan->get_instansi->alamat }} </li>
            </ol>
        </section>
        <section class="footer">
            <p>{{ $nota_pesanan->get_instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($nota_pesanan-> tgl_awal_pekerjaan)) }}</p>
            <table>
                <tr height="35px">
                    <td>Untuk dan atas nama</td>
                    <td>Pejabat pengadaan</td>
                </tr>
                <tr>
                    <td>Menerima dan menyetujui :</td>
                    <td>Untuk dan atas nama</td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <h3 class="hr">{{ $nota_pesanan->get_berwenang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $nota_pesanan->get_berwenang->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">{{ $nota_pesanan->get_supplier->pimpinan }}</h3>
                        <h3>Direktur</h3>
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

        get_rincian_barang = function () {
            $.ajax({
                url: "{{ url('detail_rincian_barang') }}/"+ '{{ $nota_pesanan->id }}',
                dataType: "json",
                data: {
                    '_token' : '{{ csrf_token() }}'
                }
            }).done(function (result) {
                table_rincian.clear().draw();
                table_rincian.rows.add(result.data).draw();
                $('#jumlah_harga-barang').text(result.jumlah_harga);
                $('#terbilang_harga_barang').text(result.terbilang);
                $('.print-area').print();
            })
        }

        get_rincian_barang();
    })
</script>
</html>