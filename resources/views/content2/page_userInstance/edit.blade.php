
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Formulir Instansi
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profil Instansi</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form class="form-horizontal form-bordered" url="{{ url('newAccount/'.$userInstance->id.'/edit') }}" method="post" enctype="multipart/form-data">
                            @if($errors->any())
                                <div class="form-group">
                                    <div class="col-md-6">
                                        @foreach( $errors as $error)
                                            <p> {{ $error }} </p>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="username">Nama Pengguna</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="username" name="username" value="{{ $userInstance->username }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="password">Password</label>
                                <div class="col-md-6">
                                    <input type="password" class="form-control" id="password" name="password" value="{{ $userInstance->password }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">Nama Lengkap</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="name" name="name" value="{{ $userInstance->name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="name">Foto</label>
                                <div class="col-md-6">
                                    <input type="file" class="form-control" id="foto" name="foto">
                                    <br>
                                    <div align="center">
                                        <img src="{{ asset('ManagementUserPhoto/'.$userInstance->photo) }}" style="height: 30%;width: 40%">
                                    </div>
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
                                <button type="submit" class="pull-righ  btn btn-primary"><li class="fa fa-check-circle"> Proses </li></button>
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