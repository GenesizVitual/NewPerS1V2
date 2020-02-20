
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Pengaturan Provinsi
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabel Provinsi</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="padding-top: 1%">
                        <a href="{{ url('tambahprovinsi') }}" class="btn btn-primary">Tambah Provinsi</a>
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Provinsi</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data as $data)
                                    <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->province }}</td>
                                    <td>
                                        <form action="{{ url('hapusprovinsi/'. $data->id) }}" method="post">
                                            <a href="{{ url('editprovinsi/'. $data->id) }}" class="btn btn-warning">Ubah</a>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="put">
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah anda akan menghapus provinsi ini...?')"> Hapus </button>
                                        </form>
                                    </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop