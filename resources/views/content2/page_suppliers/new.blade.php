
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Formulir Suplier
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"> Suplier</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('suppliers/create') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="suppliers">Suppliers</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="suppliers" name="suppliers">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="suppliers">Pimpinan</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="pimpinan" name="pimpinan" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="suppliers">Alamat</label>
                                <div class="col-md-8">
                                    <textarea class="form-control"  name="alamat"></textarea>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="suppliers">No.Kontak</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" name="no_kontak">
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary pull-right">Simpan</button>
                            </div>

                        </form>
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