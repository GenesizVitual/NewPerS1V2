
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
                        <form action="{{ url('profilInstansi') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="nama_instansi">Nama Instansi</label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="nama_instansi" name="nama_instansi">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Provinsi</label>
                                <div class="col-md-8">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="provinsi">
                                        <option > Pilih Provinsi </option>
                                        @foreach($provinsi as $provinsi)
                                            <option value="{{ $provinsi->id }}"> {{ $provinsi->province }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label">Kabupaten</label>
                                <div class="col-md-8">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="kabupaten">
                                        <option > Pilih Kabupaten </option>
                                        @foreach($kabupaten as $kabupaten)
                                            <option value="{{ $kabupaten->id }}">{{ $kabupaten->district }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 control-label">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea name="alamat" rows="5" class="form-control" placeholder="Isi Dengan Alamat lengkap Instansi anda" required=""></textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 control-label" for="no_telp">No Telepon/Handphone</label>
                                <div class="col-md-8">
                                    <input class="form-control" maxlength="20" name="no_telp">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="fax">Fax</label>
                                <div class="col-md-8">
                                    <input class="form-control"  maxlength="20" name="fax">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" for="logo">Logo</label>
                                <div class="col-md-8">
                                    <input class="form-control" type="file" name="logo">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="logo">Tingkat</label>
                                <div class="col-md-8">
                                    <input  type="radio" name="tingkat"> Provinsi
                                    <input  type="radio" name="tingkat"> Kota/Kabupaten
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