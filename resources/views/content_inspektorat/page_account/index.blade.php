
@extends('master_disperindak')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Daftar Pemeriksa Inspektorat Provinsi
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Akun Inpektorat Provinsi</h3>

                    <div class="box-tools pull-right">
                        <a href="{{ url('tambahAccountInspektorat') }}" class="btn btn-box-tool"
                                title="Collapse">Tambah Akun</a>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Provinsi</th>
                                <th>kabupaten</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($index=1)
                            @foreach($data as $data)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $data->username }}</td>
                                    <td>********</td>
                                    <td>{{ $data->getprovinsi->province }}</td>
                                    <td>{{ $data->getkabupaten->district }}</td>
                                    <td>
                                        <form action="{{ url('hapusAccountInspektorat/'. $data->id) }}" method="post">
                                            <a href="{{ url('hak_akses_inspektorat/'. $data->id) }}" class="btn btn-primary">Hak Akses</a>
                                            <a href="{{ url('ubahAccountInspektorat/'. $data->id) }}" class="btn btn-warning">Ubah</a>
                                            <input type="hidden" name="_method" value="put">
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus data ini ..??')">Hapus</button>
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