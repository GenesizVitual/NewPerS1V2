
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
                        <h3 class="box-title">Bidang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('authorized/'.$data->id.'/update') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Nama</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nama_berwenang" value="{{ $data->nama_berwenang }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Nip</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="nip" value="{{ $data->nip }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Jabatan</label>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="level">
                                        <option > Pilih Jabatan </option>
                                        <option value="1" @if($data->level==1) selected @endif> Kepala Bidang/Bagian</option>
                                        <option value="10" @if($data->level==10) selected @endif> Kepala Bagian</option>
                                        <option value="2" @if($data->level==2) selected @endif> Pengguna Barang</option>
                                        <option value="3" @if($data->level==3) selected @endif> Pengurus Barang</option>
                                        <option value="4" @if($data->level==4) selected @endif> Atasan Langsung</option>
                                        <option value="5" @if($data->level==5) selected @endif> Penyimpan Barang</option>
                                        <option value="6" @if($data->level==6) selected @endif> Pengguna Anggaran</option>
                                        <option value="7" @if($data->level==7) selected @endif> Kepala Dinas</option>
                                        <option value="8" @if($data->level==8) selected @endif> Pejabat Pengadaan</option>
                                        <option value="9" @if($data->level==8) selected @endif> PPK OPD</option>
                                    </select>
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="PUT">
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