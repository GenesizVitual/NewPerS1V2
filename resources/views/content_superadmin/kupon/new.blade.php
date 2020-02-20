
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Tambah Kupon
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
                    <h3 class="box-title">Formulir Tambah Kupon</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <form action="{{ url('store_kupon') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Pemilik kupon</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="pemilik_kupon">
                        </div>
                    </div>
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
                        <label class="col-md-3 control-label" for="username">Waktu Pelatihan</label>
                        <div class="col-md-6">
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="waktu_pelatihan">
                                <option > Pilih Waktu Pelatihan </option>
                                @foreach($data_waktuPel as $vaitem)
                                    <option value="{{ $vaitem->id }}"> {{ date('d-m-Y',strtotime($vaitem->date)) }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Bonus Pemilik Kupon</label>
                        <div class="col-md-9">
                            <textarea name="bonus_pemilik_kupon" id="editor1">Start typing...</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Bonus Pemilik Kupon 2</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="bonus_pemilik_kupon2" placeholder="Bonus Pemilik Kupon">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Bonus Perserta </label>
                        <div class="col-md-9">
                            <textarea name="bonus_peserta_kupon" id="editor2">Start typing...</textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-3 control-label" for="username">Banyak Kupon</label>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="count">
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
        })

        window.onload = function() {
            CKEDITOR.replace( 'editor1',{
                height: 600
            } );
            CKEDITOR.replace( 'editor2',{
                height: 600
            } );
        };
    </script>
@stop