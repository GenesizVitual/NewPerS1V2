
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman detail berita acara penerimaan hasil pekerjaan barang/jasa lainnya
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Detail berita acara penerimaan hasil pekerjaan barang/jasa lainnya</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('cetak_rincian_berita_acara_HP/'. $berita_acara->id) }}" target="_blank" class="btn btn-default">Cetak Surat BAHP</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <p style="text-align: center; font-size: large; font-weight: bold">
                            <u>BERITA ACARA PENERIMAAN HASIL PEKERJAAN <br> PENGADAAN BARANG/JASA LAINNYA</u>
                        </p>
                        <p style="text-align: center; font-size: medium;">
                            Nomor : {{ $berita_acara->nomor_berita_acara }}
                        </p>
                        <br>
                        <br>
                        <p>
                            Pada hari ini <label style="font-weight: normal" id="hari"> {{ $tanggal['hari'] }}</label> tanggal <label style="font-weight: normal" id="tanggal"> {{ $tanggal['tanggal'] }} </label> bulan <label style="font-weight: normal" id="bulan"> {{ $tanggal['bulan'] }} </label> tahun <b id="tahun"> {{ $tanggal['tahun'] }}</b> berdasarkan
                            Surat Keputusan Kepala {{ $instansi->instance }}
                            @if($instansi->tingkat=='1')
                                Provinsi {{ $instansi->getProvince->province }}

                            @elseif($instansi->tingkat=='2')
                                Kabupaten {{ $instansi->getDistrict->district }}
                            @elseif($instansi->tingkat=='3')
                                Kota {{ $instansi->getDistrict->district }}
                            @endif Nomor: {{ $berita_acara->no_keputusan }} Tanggal {{ $tanggal_nota['tanggal'] }}
                            {{ $tanggal_nota['bulan'] }} {{ $tanggal_nota['tahun_bil'] }} tentang Penetapan Penerima Hasil Pekerjaan {{ $instansi->instance }}
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
                            {{ $berita_acara->getNotaPesanan->get_berwenang->nama_berwenang }} pada {{ $instansi->instance }}
                            @if($instansi->tingkat=='1')
                                Provinsi {{ $instansi->getProvince->province }}

                            @elseif($instansi->tingkat=='2')
                                Kabupaten {{ $instansi->getDistrict->district }}
                            @elseif($instansi->tingkat=='3')
                                Kota {{ $instansi->getDistrict->district }}
                            @endif

                            Jabatan

                            @if($berita_acara->getNotaPesanan->get_berwenang->level==6)
                                Kuasa Pengguna Anggaran
                            @elseif($berita_acara->getNotaPesanan->get_berwenang->level==7)
                                Panitia Perencana Kegiatan
                            @endif

                        </p>
                        <p>
                           Karena jabatannya, dengan ini menyatakan dengan sebenarnya telah melaksanakan pemeriksaan terhadap penyerahan
                            barang/Jasa {{ $berita_acara->getNotaPesanan->get_berwenang->nama_berwenang }} pada {{ $instansi->instance }}
                            @if($instansi->tingkat=='1')
                                Provinsi {{ $instansi->getProvince->province }}

                            @elseif($instansi->tingkat=='2')
                                Kabupaten {{ $instansi->getDistrict->district }}
                            @elseif($instansi->tingkat=='3')
                                Kota {{ $instansi->getDistrict->district }}
                            @endif

                        </p>
                        <p>
                            Nama Perusahaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp; {{ $berita_acara->getNotaPesanan->get_supplier->suppliers }}
                            <br>
                            Alamat Perusahaan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp; {{ $berita_acara->getNotaPesanan->get_supplier->alamat }}
                            <br>
                            Yang Dalam Hal ini diwakili oleh : {{ $berita_acara->getNotaPesanan->get_supplier->pimpinan }}
                        </p>
                        <br>
                        <p>Sebagai realisasi Surat Pesanan (SP)/Surat Perintah Kerja(SPK) Nomor: {{ $berita_acara->getNotaPesanan->nomor_surat }} Tanggal {{ date('d-m-Y', strtotime($berita_acara->getNotaPesanan->tgl_awal_pekerjaan)) }} Dengan jumlah/jenis pekerjaan:</p>
                        <br>
                        <table class="table table-bordered table-striped" style="width: 100%" id='table_rincian_barang'>
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Barang</th>
                                    <th>Quantitas</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan (Rp.)</th>
                                    <th>Jumlah Harga (Rp.)</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>No.</td>
                                    <td>Nama Barang</td>
                                    <td>Quantitas</td>
                                    <td>Satuan</td>
                                    <td>Harga Satuan (Rp.)</td>
                                    <td>Jumlah Harga (Rp.)</td>
                                    <td></td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <td></td>
                                    <td colspan="4">Jumlah Harga</td>
                                    <td><p id="jumlah_harga-barang">...</p></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Terbilang : </td>
                                    <td colspan="6"><p id="terbilang_harga_barang" style="font-weight: bold"></p></td>
                                </tr>
                            </tfoot>
                        </table>
                        <p>Hasil pemeriksaan dinyatakan:
                            <ul>a). Baik</ul>
                            <ul>b). Kurang/ tidak baik</ul>
                        </p>
                        <p>Yang selanjutnya akan diserahkan oleh Penyedia Barang kepada Penyimpan Barang dan/atau Pengurus mestinya.</p>
                        <p><h4 style="text-align: center; font-weight: bold">PEJABAT PENERIMA HASIL PEKERJAAN</h4></p>
                        <div class="col-md-6">
                            <p></p>
                            <p>Pejabat Penerima Hasil<br>Pekerjaan</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u>{{ $berita_acara->getNotaPesanan->get_berwenang->nama_berwenang }}</u></p>
                            <p>NIP &nbsp;&nbsp;:&nbsp;&nbsp; {{ $berita_acara->getNotaPesanan->get_berwenang->nip }}</p>
                        </div>
                        <div class="col-md-6">
                            <p></p>
                            <p>PENYEDIA BARANG</p>
                            <p>{{ $berita_acara->getNotaPesanan->get_supplier->suppliers }}</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u>{{ $berita_acara->getNotaPesanan->get_supplier->pimpinan }}</u></p>
                            <p>Direktur</p>
                        </div>
                    </div>
                  </div>
            </div>
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->


@stop

@section('jsContainer')

    <script>
        $(document).ready(function(){
            $('#modalInsert').click(function () {
               $('#modal-rincian-barang').modal('show');
            });

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
                pagging : false,
                searching: false,
                info : true,
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
                })
            }

            deletes= function (id) {
                if(confirm('Apakah Anda Ankan menghapus data ini ...?')== true){
                    $.ajax({
                        url: "{{ url('delete_rincian_barang') }}/"+ id,
                        type: 'post',
                        data: {
                            '_token':'{{ csrf_token() }}',
                            '_method':'put'
                        },
                        success: function (result) {
                            if(result.status==true){
                                alert(result.pesan);
                            }else{
                                alert(result.pesan);
                            }
                            get_rincian_barang();
                        }
                    })
                }else{
                    alert('data tidak terhapus');
                }
            }
            
            setTimeout(function(){
                get_rincian_barang();    
            }, 2000);
        });
    </script>

@stop