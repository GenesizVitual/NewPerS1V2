
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman membuat surat Pesanan
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
                        <form action="{{ url('nota_BPH/'.$nota->id.'/update') }}" class="form-horizontal" method="post" enctype="multipart/form-data">

                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">No Surat pesanan</label>
                                <div class="col-md-9">
                                    <select class="form-control select2 select2-hidden-accessible" required style="width: 100%;" tabindex="-1" aria-hidden="true"  name="nota_id">
                                        <option > Paket Pekerjaan </option>
                                        @foreach($data_surat_pesanan as $vaitem)
                                            <option value="{{ $vaitem->id }}" @if($vaitem->id==$nota->id_nota) selected @endif> {{ $vaitem->nomor_surat}} </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Nomor Berita Acara</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="no_berita_acara" required value="{{ $nota->nomor_berita_acara }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Nomor Surat Keputusan</label>
                                <div class="col-md-9">
                                    <input type="text" class="form-control" name="no_keputusan" required value="{{ $nota->no_keputusan }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Tanggal Surat Keputusan</label>
                                <div class="col-md-9">
                                    <input type="text" id="datepicker1" class="form-control" required name="tgl_surat_keputusan" value="{{ date('d-m-Y',strtotime($nota->tgl_surat_keputusan)) }}"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label" for="username">Tanggal Berita Acara</label>
                                <div class="col-md-9">
                                    <input type="text" id="datepicker1" class="form-control" required name="tgl_berita_acara" value="{{ date('d-m-Y',strtotime($nota->tanggal_berita_acara)) }}"  data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <input type="hidden" name="_method" value="put">
                                <button type="submit" class="btn btn-primary pull-center">simpan</button>
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