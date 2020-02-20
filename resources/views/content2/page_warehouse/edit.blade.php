
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Formulir Ubah Barang
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-6">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Barang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('warehouse/'.$data->id.'/edit') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="goods_code">Kode Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="goods_code" name="goods_code" value="{{ $data->goods_code }}">
                                    <span class="required">Isi jika dibutuhkan</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="goods_name">Nama Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="goods_name" name="goods_name" value="{{ $data->goods_name }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Jenis Barang</label>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="typeofgoods">
                                        <option>Pilih Jenis Barang</option>
                                        @foreach($jenis_barang as $datas)
                                            <option  value="{{ $datas->id }}" @if($datas->id==$data->jenis_barang->id) selected @endif>{{ $datas->typeOfGoods }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="unit">Satuan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="unit" name="unit" value="{{ $data->unit }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="specs">Spesifikasi</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="specs" name="specs" value="{{ $data->specs }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="brand">Merek</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="brand" name="brand" value="{{ $data->brand }}">
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="minimum_stock">Minimum Stok</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="text" class="form-control" id="minimum_stock" name="minimum_stock" value="{{ $data->minimum_stock }}">--}}
                                    {{--<span class="required">Batas Stok yang tidak bisa digunakan</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="initial_stock">Stok Awal</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="text" class="form-control" id="initial_stock" name="initial_stock" value="{{ $data->initial_stock }}" readonly>--}}
                                    {{--<span class="required">Sisa stok tahun lalu</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="standard_price">Standar Harga Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="standard_price" name="standard_price" value="{{ $data->standard_price }}">
                                    <span class="required">standar harga barang diinstansi anda</span>
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