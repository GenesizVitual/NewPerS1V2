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
    .title {margin-top: 10mm;text-align: center;}
    .title h4 {font-size: 11pt; line-height: 3mm; font-weight: bold;text-decoration: underline;}
    .title h3 {font-size: 11pt; line-height: 3mm;margin-top: 10px;}
    .content {font-size : 10pt; line-height: 6mm; margin-top: 8mm;text-align: justify;}
    .content .start {text-indent: 5mm;}
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
    ol {padding:0;list-style-type: lower-alpha;margin: 0 0 0 10mm;}
    ol li {font-size: 10pt;line-height: 6mm;}
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
            <h4>BERITA ACARA PENERIMAAN HASIL PEKERJAAN</h4>
            <h4>PENGADAAN BARANG/JASA LAINNYA</h4>
            <h3>Nomor : {{ $berita_acara->nomor_berita_acara }}</h3>
        </section>
        <section class="content">
            <p class="start">Pada hari ini <label id="hari"> {{ $tanggal['hari'] }}</label> tanggal <label style="font-weight: normal" id="tanggal"> {{ $tanggal['tanggal'] }} </label> bulan <label id="bulan"> {{ $tanggal['bulan'] }} </label> tahun <b id="tahun"> {{ $tanggal['tahun'] }}</b> berdasarkan
                Surat Keputusan Kepala
               {{ $instansi_baru }}
                @if($instansi->tingkat=='1')
                    Provinsi {{ $instansi->getProvince->province }}

                @elseif($instansi->tingkat=='2')
                    Kabupaten {{ $instansi->getDistrict->district }}
                @elseif($instansi->tingkat=='3')
                    Kota {{ $instansi->getDistrict->district }}
                @endif

                Tahun
                Anggaran {{ $tahun_anggaran->years }}, kami bertanda tangan dibawah ini:
            </p>
            <p>
                {{ $berita_acara->getNotaPesanan->get_berwenang->nama_berwenang }} pada {{ $instansi_baru }}.
                @if($instansi->tingkat=='1')
                    Provinsi {{ $instansi->getProvince->province }}

                @elseif($instansi->tingkat=='2')
                    Kabupaten {{ $instansi->getDistrict->district }}
                @elseif($instansi->tingkat=='3')
                    Kota {{ $instansi->getDistrict->district }}
                @endif

                Jabatan

                @if($berita_acara->getNotaPesanan->get_berwenang->level==6)
                    Kuasa Pengguna Anggaran.
                @elseif($berita_acara->getNotaPesanan->get_berwenang->level==7)
                    Panitia Perencana Kegiatan.
                @endif
            </p>
            <p>
                Karena jabatannya, dengan ini menyatakan dengan sebenarnya telah melaksanakan pemeriksaan terhadap penyerahan
                barang/Jasa {{ $berita_acara->getNotaPesanan->get_berwenang->nama_berwenang }} pada {{ $instansi_baru }}
                @if($instansi->tingkat=='1')
                    Provinsi {{ $instansi->getProvince->province }}

                @elseif($instansi->tingkat=='2')
                    Kabupaten {{ $instansi->getDistrict->district }}
                @elseif($instansi->tingkat=='3')
                    Kota {{ $instansi->getDistrict->district }}
                @endif

            </p>
            <label>
                <h4><span>Nama Perusahaan</span> <p>: &nbsp; {{ $berita_acara->getNotaPesanan->get_supplier->suppliers }}</p></h4>
                <h4><span>Alamat</span> <p>: &nbsp; {{ $berita_acara->getNotaPesanan->get_supplier->alamat }}</p></h4>
            </label>
            <p>Yang Dalam Hal ini diwakili oleh : {{ $berita_acara->getNotaPesanan->get_supplier->pimpinan }}</p>
            <p>Sebagai realisasi Surat Pesanan(SP)/Surat Perintah Kerja(SPK) Nomor: {{ $berita_acara->getNotaPesanan->nomor_surat }} Tanggal {{ date('d-m-Y', strtotime($berita_acara->getNotaPesanan->tgl_awal_pekerjaan)) }} Dengan jumlah/jenis pekerjaan:</p>
            <table id="table_rincian_barang">
                <thead>
                    <tr>
                        <th >No</th>
                        <th >Nama Barang</th>
                        <th >Kuantitas</th>
                        <th >Satuan</th>
                        <th >Harga Satuan (Rp.)</th>
                        <th >Jumlah Harga (Rp.)</th>
                    </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                    <tr>
                        <td colspan="5" class="indent"><b>Jumlah Harga (Termasuk Pajak)</b></td>
                        <td id="jumlah_harga-barang" class="right">...</td>
                    </tr>
                    <tr>
                        <td colspan="6" class="indent">Terbilang : <b id="terbilang_harga_barang"></b></td>
                    </tr>
                </tfoot>
            </table>
            <label>Hasil pemeriksaan dinyatakan:
                <ol>
                    <li>Baik</li>
                    <li>Kurang/ tidak baik</li>
                </ol>
            </label>
            <p>Yang selanjutnya akan diserahkan oleh Penyedia Barang kepada Penyimpan Barang dan/atau Pengurus mestinya.</p>
            <h3>PEJABAT PENERIMA HASIL PEKERJAAN</h3>
        </section>
        <section class="footer">
            <table>
                <tr height="35px">
                    <td>Untuk dan Atas Nama</td>
                    <td>Penyedia Barang</td>
                </tr>
                <tr>
                    <td>Pejabat Penerima Hasil Pekerjaan</td>
                    <td>{{ $berita_acara->getNotaPesanan->get_supplier->suppliers }}</td>
                </tr>
                <tr height="60px"><td colspan="2">&nbsp;</td></tr>
                <tr>
                    <td>
                        <h3 class="hr">{{ $berita_acara->getNotaPesanan->get_berwenang->nama_berwenang }}</h3>
                        <h3>NIP. {{ $berita_acara->getNotaPesanan->get_berwenang->nip }}</h3>
                    </td>
                    <td>
                        <h3 class="hr">{{ $berita_acara->getNotaPesanan->get_supplier->pimpinan }}</h3>
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
                url: "{{ url('detail_rincian_barang') }}/"+ '{{ $berita_acara->id_nota }}',
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