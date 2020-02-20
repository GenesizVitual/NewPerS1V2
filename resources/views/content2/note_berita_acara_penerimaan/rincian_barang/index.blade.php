
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman detail berita acara penerimaan barang/jasa
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
                        <h3 class="box-title">Detail berita acara penerimaan barang/jasa</h3>
                        <div class="box-tools pull-right">
                            <button class="btn btn-warning" onclick="modalPopup()">Import Barang Ke Penerimaan</button>
                            <a href="{{ url('print_rincian_berita_acara/'. $berita_acara->id.'/detail') }}" target="_blank" class="btn btn-default">Cetak Surat BAPB</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <p style="text-align: center; font-size: large; font-weight: bold">
                            <u>BERITA ACARA PENERIMAAN BARANG/JASA </u>
                        </p>
                        <p style="text-align: center; font-size: medium;">
                            Nomor : {{ $berita_acara->nomor_berita_acara }}
                            <input type="hidden" name="nomor_surat" value="{{ $berita_acara->nomor_berita_acara }}">
                        </p>
                        <br>
                        <br>
                        <p>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Pada hari ini {{ $tanggal['hari'] }} tanggal {{ $tanggal['tanggal'] }} bulan {{ $tanggal['bulan'] }} Tahun <b>{{ $tanggal['tahun'] }}, </b>kami yang bertanda tangan di bawah ini:

                        </p>
                        <p style="padding-left: 2%">
                            Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $berwenang->nama_berwenang}}
                            <br>
                            NIP&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: &nbsp;{{ $berwenang->nip}}
                            <br>
                            Jabatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: Penyimpan barang {{ $instansi->instance }}
                        </p>
                        <br>
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
                        Daftar barang yang diterima sebagai berikut: </p>
                        <input type="hidden" name="id_supplier" value="{{ $berita_acara->getBeritaAcaraPH->getNotaPesanan->get_supplier->id }}">
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
                        <p>Demikian Berita Acara penerimaan Barang/Jasa ini dibuat dalam rangkap 6(enam) untuk dipergunakan sebagaimana mestinya</p>
                        <div class="col-md-6">
                            <p></p>
                            <p>Yang Menerima,<br>Penyimpan Barang</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u>{{ $berwenang->nama_berwenang}}</u></p>
                            <p>NIP &nbsp;&nbsp;:&nbsp;&nbsp;&nbsp;{{ $berwenang->nip}} </p>
                        </div>
                        <div class="col-md-6">
                            <p>
                                {{ $instansi->getDistrict->district }}
                                ,{{  date('d-m-Y', strtotime($berita_acara->tgl_berita_acara)) }}</p>
                            <p>Yang Menyerahkan,</p>
                            <p>{{  $berita_acara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers }}</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u>{{  $berita_acara->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers }}</u></p>
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


    <!-- Modal Tambah Spj -->
    <div class="modal fade" id="modal-tambah-spj" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pengaturan Import Data Barang Ke Penerimaan</h4>
                </div>

                <div class="modal-body">

                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">SPJ</label>
                            <div class="col-sm-10">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="spj_id">
                                    <option value="0">Pilih SPJ</option>
                                    @foreach($spj as $spj)
                                        <option value="{{ $spj->id }}">{{ $spj->number_spj }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">TBK</label>
                            <div class="col-sm-10">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tbk_id">
                                    <option value="0">Pilih TBK</option>
                                </select>
                                <small style="color: red">Spj dan Tbk Boleh Kosong dengan catatan SPJ dan TBK Baru Akan dibuat dengan nomor spj maupun tbk akan disesuikan dengan nomor surat</small>
                            </div>
                        </div>
                        <input type="hidden" name="id_rincian_barang">
                        <input type="hidden" name="tgl_berita_acara" value="{{ $berita_acara->tgl_berita_acara }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_import_nota_ke_penerimaan"><i id="icon_reloading" class="fa fa-fw fa-archive"></i> Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

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
                    url: "{{ url('detail_rincian_barang') }}/"+ '{{ $berita_acara->getBeritaAcaraPH->getNotaPesanan->id}}',
                    dataType: "json",
                    data: {
                        '_token' : '{{ csrf_token() }}'
                    }
                }).done(function (result) {
                    table_rincian.clear().draw();
                    table_rincian.rows.add(result.data).draw();

                    $('#jumlah_harga-barang').text(result.jumlah_harga);
                    $('[name="id_rincian_barang"]').val(result.id_rincian_barang);
                    $('#terbilang_harga_barang').text(result.terbilang);
                })
            }

            $('[name="spj_id"]').change(function () {
                $.ajax({
                    url: '{{ url('tbkResponse') }}/'+ $(this).val(),
                    dataType: 'json',
                    success: function (result) {
                        var option="<option>Pilih Tbk</option>";
                        $.each(result.tbk, function (index, value) {
                            option +="<option value='"+value.id+"'>"+value.number_tbk+"</option>"
                        })
                        $('[name="tbk_id"]').html(option)
                    }
                })
            });

            modalPopup = function () {
                $("#modal-tambah-spj").modal('show')
            }

            $('#tombol_import_nota_ke_penerimaan').click(function () {
                reload();
                $.ajax({
                    url: '{{ url('goodreceipt/multiStore') }}',
                    type: 'post',
                    data: {
                        '_token' : '{{ csrf_token() }}',
                        'spj_id' : $('[name="spj_id"]').val(),
                        'tbk_id' : $('[name="tbk_id"]').val(),
                        'id_supplier': $('[name="id_supplier"]').val(),
                        'tgl_penerimaan': $('[name="tgl_berita_acara"]').val(),
                        'id_rincian_barang': $('[name="id_rincian_barang"]').val(),
                        'nomor_surat': $('[name="nomor_surat"]').val(),
                    },success: function (result) {
                        console.log(result);
                        unreaload();
                        $("#modal-tambah-spj").modal('hide')
                        //alert("Data Nota Berhasil diimport");
                        var pesan="";
                        $.each(result, function (index, value) {
                            pesan +=value+'\n';
                        })
                        alert(pesan);
                    }
                })
            });

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

            reload=function(){
                $("#icon_reloading").attr('class', 'fa fa-refresh fa-spin');
            }

            unreaload=function(){
                $("#icon_reloading").attr('class', 'fa fa-fw fa-archive');
            }

            setTimeout(function() {
                get_rincian_barang();
            }, 2000);

        });
    </script>

@stop