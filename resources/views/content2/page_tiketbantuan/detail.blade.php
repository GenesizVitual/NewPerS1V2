
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Tiket Bantuan
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->

                <div class="col-md-12">
                    <!-- Custom Tabs -->
                   <div class="panel panel-body">
                       <p>{{ $data_tiket->masalah }}</p>
                       <p>{{ $data_tiket->penjelasan }}</p>
                       <p>{{ $data_tiket->alur_masalah }}</p>
                   </div>
                    <!-- nav-tabs-custom -->
                </div>
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop