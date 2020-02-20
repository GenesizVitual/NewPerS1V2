
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Halaman Langganan Hosting Web Premium Member
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-8">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Silahkan Pilih Paket Berlangganan Hosting Web Sebagai Premium Member</h3>
                        <div class="box-tools pull-right">
                            <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="Ubah Profil">
                                <i class="fa fa-times"></i></button>
                        </div>
                    </div>
                    <div class="box-body">
                        <form action="{{ url('prosesLangganan') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-md-8 control-label"><p>Biaya Berlangganan Hosting Web Persediaan.id sebagai Premium Member adalah berdasarkan besarnya Pagu Anggaran Persediaan Setiap OPD/SKPD yang terdapat di DPA.<br>
								</p></label>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="username">Paket Harga Langganan Hosting Web</label>
                                <div class="col-md-6">
                                    @foreach($paket_price as $harga_paket)
                                        @if($harga_paket->id!=4)
                                            <input type="radio" name="harga_paket" value="{{ $harga_paket->id }}"> {{ $harga_paket->keterangan }} ( {{ number_format($harga_paket->range,2,'.',',')}} / Bulan) <br>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="username">Periode Langganan</label>
                                <div class="col-md-6">
                                    @foreach($priode_paket as $periode_paket)
                                        <input type="radio" name="periode_paket" value="{{ $periode_paket->id }}"> {{ $periode_paket->priode }}<br>
                                    @endforeach
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-3 control-label" for="username">Total Pembayaran</label>
                                <div class="col-md-6">
                                    <h3 id="total">0</h3>
                                </div>
                            </div>
                            <div class="box-footer">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-primary pull-right">Proses</button>
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

            $('[name="harga_paket"]').click(function () {
                $.ajax({
                   url: "{{ url('get_price') }}/"+$(this).val(),
                   dataType: "JSON",
                   success: function (result) {
                       //console.log();
                       harga_price = parseInt(result.range);
                       total_paket = harga_price*periode_paket;
                       $('#total').html(addCommas(total_paket));
                   }
                });
            })

            $('[name="periode_paket"]').click(function () {
                $.ajax({
                    url: "{{ url('get_periode') }}/"+$(this).val(),
                    dataType: "JSON",
                    success: function (result) {
                        console.log(result);
                        periode_paket = parseInt(result.value);
                        total_paket = harga_price*periode_paket;
                        $('#total').html(addCommas(total_paket));
                    }
                });
            })

            addCommas=function (nStr)
            {
                nStr += '';
                x = nStr.split('.');
                x1 = x[0];
                x2 = x.length > 1 ? '.' + x[1] : '';
                var rgx = /(\d+)(\d{3})/;
                while (rgx.test(x1)) {
                    x1 = x1.replace(rgx, '$1' + ',' + '$2');
                }
                return x1 + x2;
            }
        });


    </script>
@stop