
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Tahun Anggaran
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabel Tahun Anggaran</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('fiscalyears/create') }}" data-toggle="tooltip" title="Tambah Tahun Anggaran" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Tahun Anggaran </a>
                            <table class="table mb-none">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tahun</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($index=1)
                                @foreach($fiscalYears as $fiscalYear)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $fiscalYear->years }}</td>
                                        <td>
                                            @if($fiscalYear->status==1)
                                                aktif
                                            @else
                                                tidak aktif
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ url('fiscalyears/'.$fiscalYear->id.'/destroy') }}" method="post">
                                                <a href="{{ url('fiscalyears/'.$fiscalYear->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus tahun anggaran ini data dengan tahun yang bersangkutan akan terhapus')">delete</button>
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