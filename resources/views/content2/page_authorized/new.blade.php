
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Berwenang
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Berwenang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Close">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('authorized/store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Nama</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama_berwenang">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Nip</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nip">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Jabatan</label>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="level">
                                        <option > Pilih Jabatan </option>
                                        <option value="1"> Kepala Bidang</option>
                                        <option value="10">Kepala Bagian</option>
                                        <option value="2"> Pengguna Barang</option>
                                        <option value="3"> Pengurus Barang</option>
                                        <option value="4"> Atasan Langsung</option>
                                        <option value="5"> Penyimpan Barang</option>
                                        <option value="6"> Pengguna Anggaran</option>
                                        <option value="7"> Kepala Dinas</option>
                                        <option value="8"> Pejabat Pengadaan</option>
                                        <option value="9"> PPK OPD</option>
                                    </select>
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