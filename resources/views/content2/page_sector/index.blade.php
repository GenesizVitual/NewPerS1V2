
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1 id="header_sektor">

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
                        <h3 class="box-title" id="table_header_sektor">Tabel </h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('sector/create') }}" data-toggle="tooltip" title="Tambah Tahun Anggaran" class="mb-xs mt-xs mr-xs btn btn-primary" id="button_label_bidang"> Tambah </a>
                            <table class="table mb-none">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Bidang</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($index=1)
                                @foreach($bidang as $bidang)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $bidang->sector_name }}</td>
                                        <td>
                                            <form action="{{ url('sector/'.$bidang->id.'/destroy') }}" method="post">
                                                <a href="{{ url('sector/'.$bidang->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus tahun anggaran ini data dengan Bidang yang bersangkutan akan terhapus')">delete</button>
                                            </form>
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
@stop