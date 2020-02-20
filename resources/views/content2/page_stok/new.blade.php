
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Sisa Barang
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Sisa Barang</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Close">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('storeStok') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Penerimaan<label style="color: red">*</label></label>
                                <div class="col-md-6">
                                    <input type="text" id="datepicker" class="form-control" name="tgl_akhir_catatan" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" >Barang<label style="color: red">*</label></label>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="barang">
                                        <option > Pilih Barang </option>
                                        @foreach($barang as $barang)
                                            <option value="{{ $barang->id }}"> {{ $barang->goods_name }} | {{ $barang->specs }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-3 control-label" >Tahun Anggaran<label style="color: red">*</label></label>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="tahun_anggaran">
                                        <option > Pilih Tahun Anggaran </option>
                                        @foreach($tahun_anggaran as $tahun)
                                            <option value="{{ $tahun->id }}"> {{ $tahun->years }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Harga Satuan Barang Saat Itu<label style="color: red">*</label></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="harga_satuan_stok">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" >Sisa Barang<label style="color: red">*</label></label>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" name="sisa_stok_barang">
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

@section("jsContainer")
    <script>
        $(document).ready(function () {
            $('#datepicker').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })
        })
    </script>
@stop