
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Buat Tiket
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Formulir</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('buat_tiket_bantuan') }}" class="form-horizontal" method="post">
                            <div class="form-group">
                                <label class="col-md-3 control-label">Di Tujukan</label>
                                <div class="col-md-8">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="department">
                                        <option > - </option>
                                        <option value="1"> Technical Support </option>
                                        <option value="2"> Billing Support </option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Masalah</label>
                                <div class="col-md-8">
                                    <input type="text" name="masalah" class="form-control">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label">Penjelasan Masalah <label style="color: red"> (wajib)</label></label>
                                <div class="col-md-8">
                                    <textarea name="penjel_masalah" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="form-group" id="detail">
                                <label class="col-md-3 control-label">Bagaimana Alur Munculnya Masalah <label style="color: red"> (wajib)</label></label>
                                <div class="col-md-8">
                                    <textarea name="detail_masalah" class="form-control"></textarea>
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary pull-right">Kirim</button>
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
        $(document).ready(function(){
            var harga_price = 0;
            var periode_paket = 0;
            var total_paket = 0;
            $('#detail').hide();
            $('[name="masalah"]').on('input', function () {
                if($(this).val()=='')
                {
                    $('#detail').hide();
                }else{
                    $('#detail').show();
                }
            })

        });


    </script>
@stop