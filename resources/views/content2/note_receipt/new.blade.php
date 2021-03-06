
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman membuat surat pesanan
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Form surat Pesanan</h3>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('buat_nota/store') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Nomor Surat Pesanan</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="no_surat_pesanan" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Paket Pekerjaan</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" required name="belanja_id">
                                        <option > Paket Pekerjaan </option>
                                        @foreach($belanja as $vaitem)
                                            <option value="{{ $vaitem->id }}"><label style="font-weight: bold">{{ str_replace(' ','.',$vaitem->number_belanja) }}</label> {{ $vaitem->name_belanja}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group" id="notif" style="display: none">
                                <label class="col-md-2 control-label" for="username"></label>
                                <div class="col-md-9">
                                  <label id="label-notife"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Pengguna Anggaran</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" required name="pengguna_anggaran">
                                        <option > Pengguna Anggaran </option>
                                        @foreach($berwenang as $vaitem)
                                            <option value="{{ $vaitem->id }}"> {{ $vaitem->nama_berwenang}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Supplier</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  required name="suppliers_id">
                                        <option > Supplier </option>
                                        @foreach($suppliers as $vaitem)
                                            <option value="{{ $vaitem->id }}"> {{ $vaitem->suppliers}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Tanggal Awal Pekerjaan</label>
                                <div class="col-md-9">
                                    <input type="text" id="datepicker1" class="form-control" name="tgl_awal_pekerjaan"  required data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Syarat-syarat pekerjaan</label>
                                <div class="col-md-9">
                                    <textarea name="syarat_syarat_pekerjaan" id="editor2" required class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Tanggal selesai pekerjaan</label>
                                <div class="col-md-9">
                                    <input type="text" id="datepicker" class="form-control" required name="tanggal_selesai_pekerjaan" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
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

        window.onload = function() {
            CKEDITOR.replace( 'editor2',{
                height:200
            } );
        };
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

            $('[name="belanja_id"]').change(function () {
                $.ajax({
                    url: '{{ url('cek_belanja') }}/'+$(this).val(),
                    type: 'get',
                    dataType: 'json',
                    success: function (result) {
                        console.log(result);
                        $('#notif').show();
                        $('#label-notife').text("Sisa Uang Belanja : "+result.sisa_uang);
                    }
                })
            })
        })

    </script>
@stop