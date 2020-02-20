
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Tambah Pelatihan
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <!-- Default box -->
                <div class="col-md-12">
            <!-- Default box -->
                    <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Formulir Tambah Pelatihan</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <form action="{{ url('store_waktu_pel') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Jadwal Pelatihan</label>
                        <div class="col-md-6">
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="jadwal_pelatihan">
                                <option > Pilih Jadwal </option>
                                @foreach($data_jadwalPel as $vaitem)
                                    <option value="{{ $vaitem->id }}"> {{ $vaitem->bulan }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Tanggal Pelatihan</label>
                        <div class="col-md-6">
                            <input type="text" id="datepicker" class="form-control" name="tanggal_pelatihan" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Tanggal Berakhir</label>
                        <div class="col-md-6">
                            <input type="text" id="datepicker1" class="form-control" name="tanggal_berakhir" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                        </div>
                    </div>
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username"></label>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Simpan</button>

                        </div>
                    </div>

                </div>
                <!-- /.box-body -->

                </form>

                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop

@section('jsContainer')
    <script>
        $(document).ready(function () {
            $('#datepicker').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })
            $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicke1').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })
        })
    </script>
@stop