
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Surat Permintaan
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
                        <h3 class="box-title">Tabel Surat Permintaan</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('CreateletterofRequets') }}" data-toggle="tooltip" title="Tambah Barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Buat Surat Permintaan</a>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No Surat Permintaan</th>
                                            <th>Bidang</th>
                                            <th>Tanggal Surat Permintaan</th>
                                            <th>Di Tujukan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                @php($no=1)
                                    @foreach($surat_permintaan as $value)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $value->no_surat_permintaan }}</td>
                                        <td>{{ $value->getSector->sector_name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->tgl_surat)) }}</td>
                                        <td>{{ $value->get_tujukan->nama_berwenang }}</td>
                                        <td><a href="{{ url('edit_letter_request/'.$value->id) }}" class="btn btn-warning">edit</a>
                                            <a href="{{ url('delete_letter_request/'.$value->id) }}" onclick="return confirm('Apakah anda akan menghapus surat ini...?')" class="btn btn-danger">delete</a>
                                            <a href="#" onclick="setting_surat('{{ $value->id }}')" class="btn btn-primary">cetak</a>
                                        </td>
                                    </tr>
                                     @endforeach
                                </tbody>
                            </table>
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

    <div class="modal fade" id="modal-setting-print" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Pengaturan Surat Permintaan</h4>
                </div>
                <form action="#" method="post" id="setting_surat">
                <div class="modal-body">
                    {{ csrf_field() }}
                    <div class="box-body">

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Jabatan 1</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="ttd_1" >
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Jabatan 2</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control" name="ttd_2" >
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>
                        </div>
                        <div class="form-group">
                           <div class="col-md-12">
                               <p style="color: green"> Biarkan Kosong Jika anda ingin menggunakan pengaturan bawaan </p>
                           </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="proses">Cetak</button>
                </div>
                </form>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

@stop

@section('jsContainer')

    <script>

        $(document).ready(function(){

            setting_surat = function (id) {
                $('#setting_surat').attr('action', '{{ url('PrinteLetterReq') }}/'+id);
                $('#modal-setting-print').modal('show');
            }
            
        })
    </script>

@stop