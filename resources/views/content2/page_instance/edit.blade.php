
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Edit Instansi
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Profil Instansi</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('profilInstansi/'.$data_instansi->id.'/update') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 " for="nama_instansi">Nama Instansi <label style="color: red" >*</label></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control" id="nama_instansi" name="nama_instansi" value="{{ $data_instansi->instance }}"  readonly>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 " for="nama_instansi">Singkatan Instansi <label style="color: red" >*</label></label>
                                <div class="col-md-8">
                                    <input type="text" class="form-control"  name="singkatan_instansi" value="{{ $data_instansi->singkatan_instansi }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 ">Provinsi <label style="color: red" >*</label></label>
                                <div class="col-md-8">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="provinsi" disabled>
                                        <option > Pilih Provinsi </option>
                                        @foreach($provinsi as $provinsi)
                                            <option value="{{ $provinsi->id }}" @if($provinsi->id==$data_instansi->province_id) selected @endif> {{ $provinsi->province }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 ">Kabupaten <label style="color: red" >*</label></label>
                                <div class="col-md-8">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="kabupaten" disabled>
                                        <option > Pilih Kabupaten </option>
                                        @foreach($kabupaten as $kabupaten)
                                            <option value="{{ $kabupaten->id }}" @if($kabupaten->id==$data_instansi->district_id) selected @endif>{{ $kabupaten->district }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-sm-3 ">Alamat</label>
                                <div class="col-sm-8">
                                    <textarea name="alamat" rows="5" class="form-control" placeholder="Isi Dengan Alamat lengkap Instansi anda" required="">{{ $data_instansi->alamat }}</textarea>
                                </div>
                            </div>


                            <div class="form-group">
                                <label class="col-md-3 " for="no_telp">Telp/Handphone <label style="color: red" >*</label></label>
                                <div class="col-md-8">
                                    <input class="form-control" maxlength="20" name="no_telp" value="{{ $data_instansi->no_telp }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 " for="fax">Fax</label>
                                <div class="col-md-8">
                                    <input class="form-control"  name="fax" value="{{ $data_instansi->fax }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3" for="logo">Logo <label style="color: red" >*</label></label>
                                <div class="col-md-8">
                                    <input class="form-control" type="file" name="logo">
                                    <div class="col-md-4">
                                        <h5 align="center">Logo Sekarang</h5>
                                        <img src="{{ asset('logo/'.$data_instansi->logo) }}" style="width: 100%; height: 100%" alt="Logo Tidak Tersedia">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 " >Tingkat  <label style="color: red" >*</label></label>

                                <div class="col-md-8">
                                    <input type="radio" value="1" name="tingkat" @if($data_instansi->tingkat=='1') checked @endif> Provinsi
                                    <input type="radio" value="2" name="tingkat" @if($data_instansi->tingkat=='2') checked @endif> Kota
                                    <input type="radio" value="3" name="tingkat" @if($data_instansi->tingkat=='3') checked @endif> Kabupaten
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
								<div class="col-md-3"> <label style="color: red" >Tanda * harus di isi!</label> </div>
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

@section('jsContainer')
@stop