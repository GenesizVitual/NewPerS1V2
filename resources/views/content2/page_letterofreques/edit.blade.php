
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
                    <form action="{{ url('edits_letter_request/'.$data_surat->id) }}" method="post">
                        <input type="hidden" value="put" name="_method">
                        {{ csrf_field() }}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="exampleInputEmail1">Bidang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="bidang">
                                <option>Pilih Bidang</option>
                                @foreach($bidang as $bidang)
                                    <option value="{{ $bidang->id }}" @if($bidang->id==$data_surat->sector_id) selected @endif>{{ $bidang->sector_name }}</option>
                                @endforeach
                            </select>
                        </div>
                         <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Surat Keluar</label>
                            <input type="text" id="datepicker1" value="{{ date('d-m-Y', strtotime($data_surat->tgl_surat)) }}" class="form-control" name="tgl_surat_permintaan" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Perihal Surat</label>
                            <textarea class="form-control" name="prihal">{{ $data_surat->prihal_surat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Di Tujukan Kepada</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="ditujukan">
                                <option>Pilih Pegawai</option>
                                @foreach($ditujukan as $ditujukan)
                                    <option value="{{ $ditujukan->id }}" @if($ditujukan->id==$data_surat->ditujuan) selected @endif>{{ $ditujukan->nama_berwenang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="table-responsive" style="padding-top: 1%">
                            <table id="example2" class="table table-bordered table-striped" style="width: 100%">
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
                                @php($no=1)
                                @foreach($pengeluaran as $data)
                                    <tr>
                                        <th>{{ $no++ }}</th>
                                        <th>{{ $data->get_sector->sector_name }}</th>
                                        <th>{{ $data->get_warehouse->goods_name }}</th>
                                        <th>{{ $data->exit_item }}</th>
                                        <th>{{ date('d-m-Y', strtotime($data->out_date)) }}</th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Isi Surat</label>
                            <textarea class="form-control" name="isi_surat">{{ $data_surat->isi_surat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Penutup Surat</label>
                            <textarea class="form-control" name="penutup_surat">{{ $data_surat->penutup_surat }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Pengguna Barang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="pengguna_barang">
                                <option>Pilih Pegawai</option>
                                @foreach($pengguna_barang as $pengguna_barang)
                                    <option value="{{ $pengguna_barang->id }}" @if($pengguna_barang->id==$data_surat->pengguna_barang) selected @endif>{{ $pengguna_barang->nama_berwenang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kepala Bidang</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kepala_bidang">
                                <option>Pilih Pegawai</option>
                                @foreach($kepala_bidang as $pengguna_barang)
                                    <option value="{{ $pengguna_barang->id }}" @if($pengguna_barang->id==$data_surat->kepala_bidang) selected @endif>{{ $pengguna_barang->nama_berwenang}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Tanggal Cetak</label>
                            <input type="text" id="datepicker2" class="form-control" value="{{ date('d-m-Y', strtotime($data_surat->tgl_cetak)) }}" name="tgl_cetak" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                    </div>

                    <div class="box-footer">
                         <input type="hidden" name="id_pengeluaran_old" value="{{ $data_surat->id_pengeluaran }}">
                         <input type="hidden" name="id_pengeluaran" value="{{ $data_surat->id_pengeluaran }}">
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

            $('[name="bidang"]').change(function(){
                $.ajax({
                    url:'{{ url('expendures_bidang') }}/'+$(this).val(),
                    dataType: 'json',
                    data:{
                        '_token' : '{{ csrf_token() }}'
                    }
                }).done(function (result) {
                    console.log(result);
                    table_pengeluaran.clear().draw();

                    table_pengeluaran.rows.add(result.data).draw();
                    var id_barang="";
                    console.log(result.id_barang.length)
                    if(result.id_barang.length == 0){
                        id_barang = $('[name="id_pengeluaran_old"]').val()
                    }else{
                        id_barang = result.id_barang.toString()
                    }
                    $('[name="id_pengeluaran"]').val(id_barang);
                    $('#modal-data-pengeluaran').modal({backdrop: 'static', keyboard: false});
                }).fail(function (jqXHR, textStatus,errorThrow) {

                })
            });

        })
    </script>

@stop