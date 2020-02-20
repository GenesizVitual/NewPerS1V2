
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Registrasi Pelatihan
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Table Registrasi</h3>

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
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Registrasi</th>
                                <th>Nama Peserta</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>Nama Instansi</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>No. WA</th>
                                <th>Kode Kupon</th>
                                <th>Kode Registrasi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data_registrasi as $data)
                                 <tr>
                                        <th>{{ $i++ }}</th>
                                        <th>{{ date('d-m-Y', strtotime($data->tgl_reg)) }}</th>
                                        <th>{{ $data->nm_peserta }}</th>
                                        <th>{{ $data->getProvince->province }}</th>
                                        <th>{{ $data->getKab->district }}</th>
                                        <th>{{ $data->nama_instansi }}</th>
                                        <th>{{ $data->email }} </th>
                                        <th>{{ $data->hp }}</th>
                                        <th>{{ $data->wa }}</th>
                                        <th>{{ $data->kode_kupon }}</th>
                                        <th>{{ $data->kode_registrasi }}</th>
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