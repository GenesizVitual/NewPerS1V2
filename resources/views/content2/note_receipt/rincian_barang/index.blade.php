
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halamat Rincian Barang
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
                        <h3 class="box-title">Tabel Rincian Surat</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('cetak_nota_pesanan/'. $nota_pesanan->id) }}" target="_blank" class="btn btn-default">Cetak Surat Pesanan</a>
                        </div>
                    </div>
                    <div class="box-body">
                        <p style="text-align: center; font-size: large; font-weight: bold">
                            <u>SURAT PESANAN (SP)</u>
                        </p>
                        <p style="text-align: center; font-size: medium;">
                            Nomor : {{ $nota_pesanan->nomor_surat }}
                        </p>
                        <br>
                        <br>
                        <p>Paket Pekerjaan : {{ $nota_pesanan->get_belanja->name_belanja }}</p>
                        <p style="padding-left: 5%">Yang bertanda tangan di bawah ini:</p>
                        <p>
                           Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $nota_pesanan->get_berwenang->nama_berwenang }}
                            <br>
                           Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: {{ $nota_pesanan->get_instansi->alamat }}
                            <br>
                           Jabatan&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;: @if($nota_pesanan->get_berwenang->level==6)
                                    Kuasa Pengguna Anggaran
                                @elseif($nota_pesanan->get_berwenang->level==7)
                                    Panitia penyenggara kegiatan
                                @endif </p>
                        </p>
                        <p>Selanjutnya disebut: <b>@if($nota_pesanan->get_berwenang->level==6)
                                    Kuasa Pengguna Anggaran
                                @elseif($nota_pesanan->get_berwenang->level==7)
                                    Panitia penyenggara kegiatan
                                @endif  </b></p>
                        <p>Dengan ini memerintahkan: </p>
                        <p>
                            Nama &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:  {{ $nota_pesanan->get_supplier->pimpinan }}
                            <br>
                            Alamat&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;:{{ $nota_pesanan->get_supplier->alamat }}
                            <br>
                            Yang Dalam Hal ini diwakili oleh : {{ $nota_pesanan->get_supplier->pimpinan }}
                            <br>
                            selanjutnya disebut : <b>Penyedia Barang;</b>
                        </p>
                        <br>
                        <p>Untuk mengirimkan barang dengan memperhatikan ketentuan-ketentuan sebagai berikut:</p>
                        <br>
                        <p>1. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Rincian Barang: <button class="btn btn-primary" id="modalInsert">Tambah Barang</button></p>
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
                                    <td colspan="4">Jumlah Harga(Termasuk Pajak)</td>
                                    <td><p id="jumlah_harga-barang">...</p></td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td colspan="2">Terbilang : </td>
                                    <td colspan="6"><p id="terbilang_harga_barang" style="font-weight: bold"></p></td>
                                </tr>
                            </tfoot>
                        </table>
                        <p>2. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tanggal Barang Diterima &nbsp;&nbsp;: {{ date('d-m-Y', strtotime($nota_pesanan->tanggal_selesai_pekerjaan)) }}</p>
                        <p>3. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Syarat-syarat pekerjaan &nbsp;&nbsp;:</p>
                        <p style="padding-left: 3%"><div style="padding-left: 4%">{!!   $nota_pesanan->syarat_syarat_pekerjaan !!}</div></p>
                        <p>4. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Waktu penyelesaian &nbsp;&nbsp;:{{ date('d-m-Y', strtotime($nota_pesanan->tgl_awal_pekerjaan)) }} - {{ date('d-m-Y', strtotime($nota_pesanan->tanggal_selesai_pekerjaan)) }}</p>
                        <p>5. &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Tempat pelaksanaan pekerjaan &nbsp;&nbsp;: {{ $nota_pesanan->get_instansi->alamat }} </p>
                        <div class="col-md-6">
                            <p></p>
                            <p>Untuk dan atas nama</p>
                            <p>Pejabat pengadaan</p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u> {{ $nota_pesanan->get_berwenang->nama_berwenang }}</u></p>
                            <p>NIP &nbsp;&nbsp;:&nbsp;&nbsp; {{ $nota_pesanan->get_berwenang->nip }}</p>
                        </div>
                        <div class="col-md-6">
                            <p>{{ $nota_pesanan->get_instansi->getDistrict->district }}, {{ date('d-m-Y', strtotime($nota_pesanan->	tgl_awal_pekerjaan)) }}</p>
                            <p>Menerima dan menyetujui :</p>
                            <p>Untuk dan atas nama </p>
                            <br>
                            <br>
                            <br>
                            <br>
                            <p><u>{{ $nota_pesanan->get_supplier->pimpinan }}</u></p>
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

    <!-- Modal Pengeluaran Barang-->
    <div class="modal fade" id="modal-rincian-barang" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title">Rincian Barang</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="barang">
                                    <option>Pilih Barang</option>
                                    @if(!empty($barang))
                                        @foreach($barang as $barang)
                                            <option value="{{ $barang->id }}">{{ $barang->goods_name}} | {{ $barang->goods_name}} | {{ $barang->specs}} | {{ $barang->brand}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Quantitas</label>
                            <div class="col-sm-12">
                                <input type="text" name="quantitas" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="satuan" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="harga_satuan" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_rincian">Proses</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal Pengeluaran Barang-->
    <div class="modal fade" id="modal-rincian-barang-update" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title">Rincian Barang</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="barang1">
                                    <option>Pilih Barang</option>
                                    @if(!empty($barang2))
                                        @foreach($barang2 as $bar)
                                            <option value="{{ $bar->id }}">{{ $bar->goods_name}} | {{ $bar->goods_name}} | {{ $bar->specs}} | {{ $bar->brand}}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Quantitas</label>
                            <div class="col-sm-12">
                                <input type="text" name="quantitas1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="satuan1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="harga_satuan1" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="edit_rincian">Proses</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
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
                })
            }

            setTimeout(function() {
                get_rincian_barang();
            }, 2000);

            $('#tombol_rincian').click(function () {
                $.ajax({
                    url: '{{ url('tambah_rincian_barang') }}',
                    type: 'post',
                    data: {
                        'id_nota': '{{ $nota_pesanan->id }}',
                        'id_belanja': '{{ $nota_pesanan->belanja_id }}',
                        'barang': $('[name="barang"]').val(),
                        'quantitas': $('[name="quantitas"]').val(),
                        'satuan': $('[name="satuan"]').val(),
                        'harga_satuan' : $('[name="harga_satuan"]').val(),
                        '_token':'{{ csrf_token() }}',
                    }, success: function (result) {
                        console.log(result);
                        if(result.status==true){
                            alert(result.pesan);
                        }else{
                            alert(result.pesan);
                        }
                       get_rincian_barang();
                        $('#modal-rincian-barang').modal('hide');
                    }
                })
            })

            var id_rincian_barang=0;
            edit = function (id) {
                $.ajax({
                    url: "{{ url('edit_rincian_barang') }}/"+ id,
                    dataType: "json",
                    type: 'get',
                    success: function (result) {
                        console.log(result);
                        id_rincian_barang = result.id;
                        $('[name="barang1"]').val(result.id_barang).trigger('change');
                        $('[name="quantitas1"]').val(result.quntitas);
                        $('[name="satuan1"]').val(result.satuan);
                        $('[name="harga_satuan1"]').val(result.harga_satuan);
                        $('#modal-rincian-barang-update').modal('show');
                    }
                })
            }

            $('#edit_rincian').click(function () {
                $.ajax({
                    url: '{{ url('ubah_rincian_barang') }}/'+id_rincian_barang,
                    type: 'post',
                    data: {
                        'id_nota': '{{ $nota_pesanan->id }}',
                        'id_belanja': '{{ $nota_pesanan->belanja_id }}',
                        'barang': $('[name="barang1"]').val(),
                        'quantitas': $('[name="quantitas1"]').val(),
                        'satuan': $('[name="satuan1"]').val(),
                        'harga_satuan' : $('[name="harga_satuan1"]').val(),
                        '_token':'{{ csrf_token() }}',
                        '_method':'put'
                    }, success: function (result) {
                        if(result.status==true){
                            alert(result.pesan);
                        }else{
                            alert(result.pesan);
                        }
                        $('#modal-rincian-barang-update').modal('hide');
                        get_rincian_barang();
                    }
                })
            })

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

        });
    </script>

@stop