
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Pesan Pengguna
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabel Pesan </h3>

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
                        <a href="{{ url('pesan_to/'.$user_id) }}" class="btn btn-primary">Kirim Pesan</a>
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Pesan</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data_pesan as $pesan)
                                    <tr>
                                        <th>{{ $i++ }}</th>
                                        <th>{!! $pesan->msg !!}</th>
                                        <th>
                                            @if($pesan->status==0)
                                                <label>Pesan belum dibaca</label>
                                            @else
                                                <label>Sudah Dibaca</label>
                                            @endif
                                        </th>
                                        <th>
                                            <form action="{{ url('hapus_pesan/'.$pesan->id) }}" class="form-horizontal" method="post">
                                                <input type="hidden" name="_method" value="PUT">
                                                {{ csrf_field() }}
                                            <button type="submit" onclick="return confirm('Apakah anda akan membatalkan pesan ini..?')" class="btn btn-danger"> batalkan pesan </button>
                                            </form>
                                        </th>
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