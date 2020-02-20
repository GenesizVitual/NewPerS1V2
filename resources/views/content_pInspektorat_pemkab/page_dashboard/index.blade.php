
@extends('master_p_inspektorat_pemkab')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Instansi Yang Anda Bisa Akses
            </h1>
         </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Instansi</h3>

                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Instansi</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($index=1)
                                @foreach($data_instansi as $value)
                                    <tr>
                                        <th>{{ $index++ }}</th>
                                        <th>{{ $value->getInstansi->instance }}</th>
                                        <th><a href="{{ url('lihatInstansiPemkab_in/'.$value->instansi_id)}}">Lihat</a> </th>
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