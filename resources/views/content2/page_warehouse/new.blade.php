
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Formulir Barang
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
                    </div>
                    <div class="box-body">
                        <form action="{{ url('warehouse/create') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="goods_code">Kode Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="goods_code" name="goods_code">
                                    <span style="color: red">Isi jika dibutuhkan</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="goods_name">Nama Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="goods_name" name="goods_name">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label">Jenis Barang</label>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="typeofgoods">
                                        <option>Pilih Jenis Barang</option>
                                        @foreach($jenis_barang as $data)
                                            <option  value="{{ $data->id }}">{{ $data->typeOfGoods }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="unit">Satuan</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="unit" name="unit">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="specs">Spesifikasi</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="specs" name="specs">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="brand">Merek</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="brand" name="brand">
                                </div>
                            </div>
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="minimum_stock">Minimum Stok</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="text" class="form-control" id="minimum_stock" name="minimum_stock">--}}
                                    {{--<span style="color: red">Batas Stok yang tidak bisa digunakan</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            {{--<div class="form-group">--}}
                                {{--<label class="col-md-4 control-label" for="initial_stock">Stok Awal</label>--}}
                                {{--<div class="col-md-6">--}}
                                    {{--<input type="text" class="form-control" id="initial_stock" name="initial_stock">--}}
                                    {{--<span style="color: red">Sisa stok tahun lalu</span>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <div class="form-group">
                                <label class="col-md-4 control-label" for="standard_price">Standar Harga Barang</label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="standard_price" name="standard_price" value="0">
                                    <span style="color: red">standar harga barang diinstansi anda</span>
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