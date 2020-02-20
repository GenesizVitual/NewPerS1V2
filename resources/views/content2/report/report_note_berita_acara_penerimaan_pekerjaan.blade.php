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
    <style>@page { size: legal }</style>
</head>
<style type="text/css">
     .header img { width: 90px;float:left; margin-top: -3mm}
    .header h4  { font-size: 11pt; line-height: 3mm; text-align:center;}
    hr {border-color: black; margin: 5px 0;}
    .title {margin-top: 10mm;text-align: center;}
    .title h4 {font-size: 11pt; line-height: 3mm; font-weight: bold;text-decoration: underline;}
    .title h3 {font-size: 11pt; line-height: 3mm;margin-top: 10px;}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 8mm;text-align: justify;}
    .content .start {text-indent: 5mm;margin-bottom: 0}
    .content label {font-weight: normal;margin-bottom: 0}
    .content h4 {font-size: 10pt;line-height: 3mm;margin: 10px 0}
    .content h4 span {float:left;}
    .content h4 p {margin-left: 35mm;}
    .content h3 {font-size:10pt; line-height: 3mm; text-align: center;font-weight: bold}
    table {width: 100%!important; font-size: 10pt;margin: 10px 0;line-height: 3mm}
    tr, th, td{border: 1px solid #000;padding-top: 5px; padding-bottom: 5px;}
    th {text-align: center;}
    tbody tr td:first-child,
    tbody tr td:nth-child(3),
    tbody tr td:nth-child(4) {text-align: center;}
    tbody tr td:nth-child(2) {text-align: left;padding-left: 5px}
    tbody tr td:nth-child(5),
    tbody tr td:nth-child(6) {text-align: right; padding-right: 5px;}
    .indent {padding-left: 5px;}
    .right {text-align: right;padding-right: 5px;}
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
            <H4>{{ strtoupper($instansi_baru) }} </H4>
            <h4>PROVINSI {{ strtoupper($instansi->getProvince->province) }}</h4>
            <h4>{{ $instansi->alamat }}</h4>
            <h4>No.Telp/Fax: {{ $instansi->no_telp }} - {{ $instansi->fax }}</h4>
        </section>
        <hr style="border-width: 3px;">
        <hr style="border-width: 1px;">
        <section class="title">
            <h4>BERITA ACARA PENERIMAAN BARANG/JASA LAINNYA</h4>
            <h3>Nomor : {{ $berita_acara->nomor_berita_acara }}</h3>
        </section>
        <section class="content">
            <p class="start">Pada hari ini {{ $tanggal['hari'] }} tanggal {{ $tanggal['tanggal'] }} bulan {{ $tanggal['bulan'] }} Tahun <b>{{ $tanggal['tahun'] }}, </b>kami yang bertanda tangan di bawah ini:</p>
            <label>
                <h4><span>Nama</span> <p>: &nbsp; {{ $berwenang->nama_berwenang}}</p></h4>
                <h4><span>NIP</span> <p>: &nbsp; {{ $berwenang->nip}}</p></h4>
                <h4><span>Jabatan</span> <p>: &nbsp; Penyimpan barang {{ $instansi_baru }}</p></h4>
            </label>
            <p>Berdasarkan Surat Keputusan Sekretaris Daerah
                @if($instansi->tingkat=='1')
                    Provinsi {{ $instansi->getProvince->province }}

                @elseif($instansi->tingkat=='2')
                    Kabupaten {{ $instansi->getDistrict->district }}
                @elseif($instansi->tingkat=='3')
                    Kota {{ $instansi->getDistrict->district }}
                @endif

                Nomor : {{ $berita_acara->nomor_surat_keputusan  }} tanggal {{ $tanggal_surat_keputusan['tanggal'] }} {{ $tanggal_surat_keputusan['bulan'] }} {{ $tanggal_surat_keputusan['tahun_bil'] }} tentang Penetapan penyimpan Barang Pada Satuan Kerja pemerintah

                @if($instansi->tingkat=='1')
                    Provinsi {{ $instansi->getProvince->province }}

                @elseif($instansi->tingkat=='2')
                    Kabupaten {{ $instansi->getDistrict->district }}
                @elseif($instansi->tingkat=='3')
                    Kota {{ $instansi->getDistrict->district }}
                @endif

                Tahun Anggaran {{ $tahun_anggaran->years }} telah menerima barang yang diserahkan
                oleh : <b>{{  $berita_acara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers }}</b> sesuai dengan Berita Acara Penerimaan Hasil Pekerjaan Nomor : {{  $berita_acara->getBeritaAcaraPH->nomor_berita_acara }} Tanggal {{  $berita_acara->getBeritaAcaraPH->tanggal_berita_acara }} <br>
            </p>
            <p>Daftar barang yang diterima sebagai berikut:</p>
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
                        <td id="jumlah_harga-barang" class="right">...</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="indent">Terbilang : <b id="terbilang_harga_barang"></b></td>
                    </tr>
                </tfoot>
            </table>
            <p>Demikian Berita Acara penerimaan Barang/Jasa ini dibuat dalam rangkap 6(enam) untuk dipergunakan sebagaimana mestinya</p>
        </section>
        <section class="footer">
            <p>{{ $instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($berita_acara->tgl_berita_acara)) }}</p>
            <table>
                <tr height="35px">
                    <td>Yang Menerima</td>
                    <td>Yang Menyerahkan</td>
                </tr>
                <tr>
                    <td>Penyimpan Barang</td>
                    <td>{{  $berita_acara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers }}</td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <h3 class="hr">{{ $berwenang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $berwenang->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">{{  $berita_acara->getBeritaAcaraPH->getNotaPesanan->get_supplier->pimpinan }}</h3>
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
                url: "{{ url('detail_rincian_barang') }}/"+ '{{ $berita_acara->getBeritaAcaraPH->getNotaPesanan->id}}',
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