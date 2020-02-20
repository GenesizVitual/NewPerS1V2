
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Tambah Admin Inspektorat Pemkot
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Default box -->
                <div class="col-md-6">
            <!-- Default box -->
                    <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Formulir Tambah Admin Inspektorat Pemkot</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <form action="{{ url('storeSuperadminInspektoratPemkot') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">

                        <div class="form-group">
                            <label class="col-md-3 control-label" for="username">Nama Pengguna</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control" name="username">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="username">Password</label>
                            <div class="col-md-9">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="username">Provinsi</label>
                            <div class="col-md-9">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="provinsi">
                                    <option > - </option>
                                    @foreach($provinsi as $val)
                                        <option value="{{ $val->id }}"> {{ $val->province }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3 control-label" for="username">Kabupaten</label>
                            <div class="col-md-9">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="kabupaten">
                                    <option > - </option>
                                    @foreach($kabupaten as $val)
                                        <option value="{{ $val->id }}"> {{ $val->district }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username"></label>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan</button>

                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

                </form>

                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop