
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Formulir Jenis Barang
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Jenis barang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('typeOfGoods/'.$jenis_barang->id.'/edit') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="jenis_barang">Jenis Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="jenis_barang" name="jenis_barang" value="{{ $jenis_barang->typeOfGoods}}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="jenisBarang">Mode perhitungan</label>
                                <div class="col-md-6">
                                    <p><input type="radio" value="1" name="formula" @if($jenis_barang->formula == '1') checked @endif> aktif
                                        <input type="radio" value="0" name="formula" @if($jenis_barang->formula == '0') checked @endif> non aktif
                                    </p>
                                    <span style="color:red;">*Mode perhitungan adalah untuk mengaktifkan rumus pembulatan</span>
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