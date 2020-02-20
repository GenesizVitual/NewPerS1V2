
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Surat Pengeluaran
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
                        <h3 class="box-title">Tabel Surat Pengeluaran</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('CreateletterofExpenditure') }}" data-toggle="tooltip" title="Tambah Barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Buat Surat Pengeluaran</a>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>No Surat Pengeluaran</th>
                                            <th>Bidang</th>
                                            <th>Tanggal Surat Pengeluaran</th>
                                            <th>Di Tujukan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                <tbody>
                                @php($no=1)
                                    @foreach($surat_pengeluaran as $value)
                                    <tr>
                                        <td>{{ $no++ }}</td>
                                        <td>{{ $value->no_surat_pengeluaran }}</td>
                                        <td>{{ $value->getSector->sector_name }}</td>
                                        <td>{{ date('d-m-Y', strtotime($value->tgl_surat_keluar)) }}</td>
                                        <td>{{ $value->get_tujukan->nama_berwenang }}</td>
                                        <td><a href="{{ url('EditletterofExpenditure/'.$value->id) }}" class="btn btn-warning">edit</a> <a href="{{ url('DeleteletterofExpenditure/'.$value->id) }}" onclick="return confirm('Apakah anda akan menghapus surat ini...?')" class="btn btn-danger">delete</a> <a href="{{ url('PrinteLetterExp/'.$value->id) }}" class="btn btn-primary">cetak</a> </td>
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

@section('jsContainer')

    <script>

        $(document).ready(function(){

        })
    </script>

@stop