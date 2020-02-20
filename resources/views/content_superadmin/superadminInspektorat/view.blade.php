
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Daftar Akun Admin Inspektorat Pemerintah Provinsi
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabel Admin Inspektorat Pemerintah Provinsi</h3>

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
                        <a href="{{ url('tambahaccountsuperadminInspektorat') }}" class="btn btn-primary">Tambah Account</a>
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Username</th>
                                <th>Password</th>
                                <th>Provinsi</th>
                                <!--<th>Kabupaten/Kota</th>-->
                                 <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data as $data)
                                    <tr>
                                    <td>{{ $i++ }}</td>
                                    <td>{{ $data->account }}</td>
                                    <td>*************</td>
                                    <td>{{ $data->getProvince->province }}</td>
                                    <!--<td>{{ $data->getDistrict->district }}</td>-->
                                    <td>
                                        <form action="{{ url('hapusaccountsuperadmininspektorat/'. $data->id) }}" method="post">
                                            <a href="{{ url('ubahaccountsuperadmininspektorat/'. $data->id) }}" class="btn btn-warning">Ubah</a>
                                            {{ csrf_field() }}
                                            <input type="hidden" name="_method" value="put">
                                            <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah anda akan menghapus account ini...?')"> Hapus </button>
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
                    
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop