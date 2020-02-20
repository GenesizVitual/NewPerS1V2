
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Profil Instansi
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-6">
                <div class="box">
                    @if(!empty($instansi_profil))

                    <div class="box-header with-border">
                        <h3 class="box-title">Profil Instansi</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('editInstansi/'.$instansi_profil->id.'/edit') }}" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-fw fa-pencil"></i></a>
                        </div>
                    </div>
                    <div class="box-body">
                            <div class="col-md-6">
                                <p>
                                    <strong>Instansi : {{ $instansi_profil->instance }}</strong>
                                </p>
                                <p>
                                    <strong>Instansi : {{ $instansi_profil->singkatan_instansi }}</strong>
                                </p>
                                <p>
                                     <strong>Provinsi : {{ $instansi_profil->getProvince->province }}</strong>
                                </p>
                                <p>
                                    <strong>Kabupaten : {{ $instansi_profil->getDistrict->district }}</strong>
                                </p>
                                <p>
                                    <strong>Alamat : {{ $instansi_profil->alamat }}</strong>
                                </p>
                                <p>
                                    <strong>Telepon : {{ $instansi_profil->no_telp }}</strong>
                                </p>
                                <p>
                                    <strong>Fax : {{ $instansi_profil->fax }}</strong>
                                </p>
                                <p>
                                    @if($instansi_profil->tingkat == 0)
                                    <strong style="color: red">Tingkat : Belum dimasukan</strong>
                                    @elseif($instansi_profil->tingkat == 1)
                                    <strong>Tingkat : Provinsi</strong>
                                    @elseif($instansi_profil->tingkat == 2)
                                    <strong>Tingkat : Kota</strong>
                                    @else
                                    <strong>Tingkat : Kabupaten</strong>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-3">
                                <img style="height: 150%; width: 150%" src="{{ asset('logo/'.$instansi_profil->logo) }}" style="width: 100%; height: 100%" alt="Logo Tidak Ditemukan">
                            </div>
                        @else
                        <div class="alert alert-warning alert-dismissible">
                            <h4><i class="icon fa fa-warning"></i>Anda Belum mengisi Profil Instansi Anda</h4>
                            <p>Profil Instansi Adalah ....</p>
                            <small>Tekan Tombol Ini untuk Mengisi Instansi Anda <a href="{{ url('profilInstansi') }}" class="btn btn-social-icon btn-flickr"><i class="fa fa-flickr"></i></a> </small>
                        </div>
                        @endif
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