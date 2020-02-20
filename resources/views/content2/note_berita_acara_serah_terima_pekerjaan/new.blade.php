
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman membuat berita acara serah terima pekerjaan
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form berita acara serah terima pekerjaan </h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('tambah_berita_acara_serah_terima_pekerjaan/store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">No Surat Berita Acara Serah Terima Barang</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 select2-hidden-accessible" required style="width: 100%;" tabindex="-1" aria-hidden="true"  name="berita_acara_penerimaan_id">
                                        <option > Paket Pekerjaan </option>
                                        @foreach($data_berita_acara as $vaitem)
                                            <option value="{{ $vaitem->id }}"> {{ $vaitem->nomor_berita_acara}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Nomor Berita Acara Serah Terima</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required name="nomor_surat" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Tanggal Berita Acara</label>
                                <div class="col-md-9">
                                    <input type="text" id="datepicker1" class="form-control" required name="tanggal_serah_terima"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Nomor Surat Perintah</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" required name="nomor_surat_perintah" >
                                </div>
                            </div>
                           <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Tanggal Surat Perintah</label>
                                <div class="col-md-9">
                                    <input type="text" id="datepicker2" class="form-control" required name="tgl_surat_perintah"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Mengetahui,</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 select2-hidden-accessible" required style="width: 100%;" tabindex="-1" aria-hidden="true"  name="mengetahui">
                                        <option > Mengetahui </option>
                                        @foreach($berwenang as $vaitem)
                                            <option value="{{ $vaitem->id }}"> {{ $vaitem->nama_berwenang }} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="box-footer">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary pull-center">Buat</button>
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


@section('jsContainer')
    <script>

//        window.onload = function() {
//            CKEDITOR.replace( 'editor2',{
//                height:200
//            } );
//        };
        $(document).ready(function () {
            $('#datepicker').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })

            $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker1').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })

             $('#datepicker2').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker2').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })


        })

    </script>
@stop