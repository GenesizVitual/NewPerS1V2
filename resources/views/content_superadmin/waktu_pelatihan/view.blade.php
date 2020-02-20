
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Waktu Pelatihan
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Table Waktu Pelatihan</h3>

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
                        <a href="{{ url('create_waktu_pelatihan') }}" class="btn btn-primary">Tambah Waktu Pelatihan</a>
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Tanggal Pelatihan</th>
                                <th>Bulan</th>
                                <th>Kabupaten</th>
                                <th>Tempat</th>
                                <th>Tanggal tutup</th>
                                <th>aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data_waktu_pel as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->date)) }}</td>
                                        <td>{{ $data->get_jadwal_pelatihan->bulan }}</td>
                                        <td>{{ $data->get_jadwal_pelatihan->getDistrict->district }}</td>
                                        <td>{{ $data->get_jadwal_pelatihan->tempat}}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->date_close)) }}</td>
                                        <td>
                                            <form action="{{ url('hapus_hapus_pel/'. $data->id) }}" method="post">
                                                <a href="{{ url('edit_waktu_pel/'. $data->id) }}" class="btn btn-warning">Ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                <button class="btn btn-danger" type="submit" onclick="return confirm('Apakah anda akan menghapus kabupaten ini...?')"> Hapus </button>
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