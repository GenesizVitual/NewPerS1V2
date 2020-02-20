
@extends('master_inspektorat_pemkab')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Daftar Akun Pemeriksa Inspektorat Kabupaten
            </h1>

        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Akun Pemeriksa Inspektorat Kabupatenn</h3>

                    <div class="box-tools pull-right">
                        <a href="{{ url('createAdminInspektoratPemkab') }}" class="btn btn-box-tool"
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
                                <th>Kabupaten/Kota</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($index=1)
                            @foreach($data as $data)
                                <tr>
                                    <td>{{ $index++ }}</td>
                                    <td>{{ $data->account }}</td>
                                    <td>********</td>
                                    <td>{{ $data->getProvince->province }}</td>
                                    <td>{{ $data->getdistrict->district }}</td>
                                    <td>
                                        <form action="{{ url('deleteAdminInspektoratPemkab/'. $data->id) }}" method="post">
                                            <a href="{{ url('hak_akses_inspektorat_pemkab/'. $data->id) }}" class="btn btn-primary">Hak Akses</a>
                                            <a href="{{ url('editAdminInspektoratPemkab/'. $data->id) }}" class="btn btn-warning">Ubah</a>
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