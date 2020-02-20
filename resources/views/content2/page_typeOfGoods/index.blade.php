
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Jenis Barang
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
                        <h3 class="box-title">Tabel Jenis Barang</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <a href="{{ url('typeOfGoods/create') }}" data-toggle="tooltip" title="Tambah jenis Barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Jenis barang</a>

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Jenis Barang</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($daftar_jenis_barang as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $data->typeOfGoods }}</td>
                                        <td>
                                            <form action="{{ url('typeOfGoods/'.$data->id.'/delete') }}" method="post">
                                                <a href="{{ url('typeOfGoods/'.$data->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                @if(!empty($data->gudang))
                                                    Jenis Barang tidak bisa dihapus karena sudah di gunakan pada jenis barang digudang
                                                @else
                                                    <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus jenis Barang ini data dengan tahun yang bersangkutan akan terhapus')">hapus</button>
                                                @endif
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