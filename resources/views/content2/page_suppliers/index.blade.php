
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Suplier
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
                        <h3 class="box-title">Tabel Suplier</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <a href="{{ url('suppliers/create') }}" data-toggle="tooltip" title="Tambah Suplier" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Suplier</a>

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Suplier</th>
                                    <th>Pimpinan</th>
                                    <th>Alamat</th>
                                    <th>No. Kontak</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($supplier as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $data->suppliers }}</td>
                                        <td>{{ $data->pimpinan }}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>{{ $data->no_kontak_supplier }}</td>
                                        <td>
                                            <form action="{{ url('suppliers/'.$data->id.'/delete') }}" method="post">
                                                <a href="{{ url('suppliers/'.$data->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus supplier ini data dengan suppliers yang bersangkutan akan terhapus')">hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
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