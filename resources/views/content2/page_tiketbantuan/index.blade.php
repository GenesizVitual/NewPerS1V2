
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
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Open</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Selesai</a></li>
                            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="table-responsive">
                                    <a href="{{ url('buat_tiket_bantuan') }}" data-toggle="tooltip" class="mb-xs mt-xs mr-xs btn btn-primary pull-right"> Buat Tiket </a>
                                    <table class="table mb-none">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiket</th>
                                            <th>status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($i=1)
                                        @foreach($data as $value)
                                            <tr>
                                                <th>{{ $i++ }}</th>
                                                <th>{{ $value->masalah }}</th>
                                                <th>
                                                    @if($value->status==1)
                                                        Sedang diproses
                                                    @endif
                                                </th>
                                                <th>
                                                    <a href="{{ url('lihattiket/'.$value->id) }}" class="btn btn-success"> lihat </a>
                                                </th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="table-responsive">
                                    <table class="table mb-none">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tiket</th>
                                            <th>status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($i=1)
                                        @foreach($data_selesai as $value)
                                            <tr>
                                                <th>{{ $i++ }}</th>
                                                <th>{{ $value->masalah }}</th>
                                                <th>
                                                    @if($value->status==2)
                                                        Selesai
                                                    @endif
                                                </th>
                                                <th>
                                                    <a href="{{ url('lihattiket/'.$value->id) }}" class="btn btn-success"> lihat </a>
                                                </th>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
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