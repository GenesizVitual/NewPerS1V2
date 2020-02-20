
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Buat Surat Permintaan
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabel Buat Surat Permintaan</h3>
                    </div>
                    <form action="{{ url('letterRequest/create') }}" method="post">
                        {{ csrf_field() }}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Bidang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="bidang">
                                <option>Pilih Bidang</option>
                                @foreach($bidang as $bidang)
                                    <option value="{{ $bidang->id }}">{{ $bidang->sector_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Barang Barang</label>
                            <input type="text" id="datepicker3" class="form-control" name="tgl_barang" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                        <div class="form-group">
                            <button type="button" id="ambil_barang" class="btn btn-primary">Ambil Barang</button>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Surat Permintaan</label>
                            <input type="text" id="datepicker1" class="form-control" name="tgl_surat_permintaan" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Perihal Surat</label>
                            <textarea class="form-control" name="prihal">Permintaan Barang</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Di Tujukan Kepada</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="ditujukan">
                                <option>Pilih Pegawai</option>
                                @foreach($ditujukan as $index => $ditujukan)
                                    <option value="{{ $ditujukan->id }}" @if($index > 0) selected @endif>{{ $ditujukan->nama_berwenang}} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="table-responsive" style="padding-top: 1%">
                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bidang</th>
                                    <th>Nama Barang</th>
                                    <th>Jumlah Keluar</th>
                                    <th>Tanggal Keluar</th>

                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Isi Surat</label>
                            <textarea class="form-control" name="isi_surat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Penutup Surat</label>
                            <textarea class="form-control" name="penutup_surat"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pengguna Barang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="pengguna_barang">
                                <option>Pilih Pegawai</option>
                                @foreach($pengguna_barang as $index2=> $pengguna_barang)
                                    <option value="{{ $pengguna_barang->id }}" @if($index2 > 0) selected @endif >{{ $pengguna_barang->nama_berwenang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kepala Bidang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kepala_bidang">
                                <option>Pilih Pegawai</option>
                                @foreach($kepala_bidang as $index3=> $pengguna_barang)
                                    <option value="{{ $pengguna_barang->id }}"  @if($index3 > 0) selected @endif>{{ $pengguna_barang->nama_berwenang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Cetak</label>
                            <input type="text" id="datepicker2" class="form-control" name="tgl_cetak" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                    </div>

                    <div class="box-footer">
                        <input type="hidden" name="id_pengeluaran">
                        <button type="submit" class="btn btn-primary">Buat</button>
                    </div>
                    </form>
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

            $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
            //Date picker
            $('#datepicker1').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })

            $('#datepicker2').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
            //Date picker
            $('#datepicker2').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })

            $('#datepicker3').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
            //Date picker
            $('#datepicker3').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })

            table_pengeluaran = $('#example1').DataTable({
                data:[],

                column:[
                    {'data' :'0'},
                    {'data' :'1'},
                    {'data' :'2'},
                    {'data' :'3'},
                    {'data' :'4'},
                ],
                rowCallback : function(row, data){

                },
                filter: false,
                pagging : true,
                searching: true,
                info : true,
                ordering : true,
                processing : true,
                retrieve: true
            });

//            $('[name="bidang"]').change(function(){
//
//            });

            $('#ambil_barang').click(function () {
                $.ajax({
                    url:'{{ url('expendures_bidang_permintaan') }}',
                    dataType: 'json',
                    type: "post",
                    data:{
                        '_token' : '{{ csrf_token() }}',
                        '_method': 'put',
                        'bidang': $('[name="bidang"]').val(),
                        'tgl_permintaan': $('[name="tgl_barang"]').val()
                    }
                }).done(function (result) {
                    table_pengeluaran.clear().draw();
                    table_pengeluaran.rows.add(result.data).draw();
                    $('[name="id_pengeluaran"]').val(result.id_barang.toString());
                    $('#modal-data-pengeluaran').modal({backdrop: 'static', keyboard: false});
                }).fail(function (jqXHR, textStatus,errorThrow) {

                })
            });
        })
    </script>

@stop