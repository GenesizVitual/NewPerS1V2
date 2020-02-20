
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Ubah Biaya Pelatihan
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
                            <h3 class="box-title">Formulir Biaya Pelatihan</h3>
                            <div class="box-tools pull-right">
                                <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                        title="Collapse">
                                    <i class="fa fa-minus"></i></button>
                                <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-times"></i></button>
                            </div>
                        </div>
                        <form action="{{ url('update_biaya_pel/'.$data->id) }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="box-body">
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="username">Jadwal Pelatihan</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="jadwal_pelatihan">
                                            <option > Pilih Jadwal </option>
                                            @foreach($data_jadwalPel as $vaitem)
                                                <option value="{{ $vaitem->id }}" @if($vaitem->id==$data->id_jadwal_pel) selected @endif> {{ $vaitem->bulan }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="username">Waktu Pelatihan</label>
                                    <div class="col-md-6">
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="waktu_pelatihan">
                                            <option > Pilih Waktu </option>
                                            @foreach($waktu_pelatihan as $vaitem)
                                                <option value="{{ $vaitem->id }}"  @if($vaitem->id==$data->id_waktu_pel) selected @endif> {{ date('d-m-Y', strtotime($vaitem->date)) }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="username">Tanggal Early Bird</label>
                                    <div class="col-md-6">
                                        <input type="text" id="datepicker" class="form-control" name="tanggal_bayar_duluan" value="{{ date('d-m-Y', strtotime($data->tgl_early_bird)) }}" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="username">Besaran Cashback</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="besaran_cashback" value="{{ $data->besar_cashback }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="username">Biaya Normal</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" name="jumlah_biaya"  value="{{ $data->jumlah_biaya }}">
                                    </div>
                                </div>
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label class="col-md-3 control-label" for="username"></label>
                                    <input type="hidden" name="_method" value="put">
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
        })
    </script>
@stop