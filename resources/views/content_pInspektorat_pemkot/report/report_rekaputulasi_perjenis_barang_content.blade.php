
@extends('master_p_inspektorat_pemkot')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->

        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Laporan Rekapitulasi Persediaan
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">

                <div class="col-md-12">
                    <div class="box box-primary">
                        <div class="box-header with-border">
                            <h3 class="box-title">Laporan Rekapitulasi Persediaan</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start {{ url('print_laporan_perjenis_barang') }} -->

                            <div class="box-body">
                            <button type="button" onclick="show_report_setting()" class="btn btn-primary">Print Rekapitulasi</button>
                                <p></p>
                                <p></p>
                                <table class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Jenis Barang</th>
                                        <th>Jumlah Total Perjenis Barang</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $jenis_barang)
                                            <tr>
                                                <th>{{ $jenis_barang[0] }}</th>
                                                <th>{{ $jenis_barang[1] }}</th>
                                                <th>{{ number_format($jenis_barang[2],2,'.',',') }}</th>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td></td>
                                            <th >Jumlah Total Per Jenis Barang</th>
                                            <th >{{ number_format($total_harga_permintaan->totalPerjenis_barang,2,'.',',') }}</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.box-body -->
                    </div>
                </div>
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <div class="modal fade" id="modal-report-setting" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title">Pengaturan cetak</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Tanggal Cetak</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker1" class="form-control" name="tanggal_cetak" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Format Print</label>
                            <div class="col-sm-12">
                                <input type="radio" name="ext" value="1"> <label style="padding-right: 1%">Print Langsung</label>
                                {{--<input type="radio" name="ext" value="2"> <label style="padding-right: 1%">.Pdf</label>--}}
                                {{--<input type="radio" name="ext" value="3"> <label style="padding-right: 1%">.xlc</label>--}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" id="proses_print" ><i class="fa fa-fw fa-print"></i> Proses</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@stop


@section('jsContainer')
    <script >
        $(document).ready(function () {


                $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

                $('#datepicker1').datepicker({
                    autoclose: true,
                    format: 'dd-mm-yyyy'
                })


            table_laporan = $('#example3').DataTable({
                data:[],
                column : [
                    {'data':'0'},
                    {'data':'1'},
                    {'data':'2'},
                    {'data':'3'},
                    {'data':'4'}
                ],
                rowCallback : function (row, data) {

                },
                pagging:true,
                ordering:false,
                info: false,
                processing:true,
                retrieve : true
            });

            loadData = function(){
                $.ajax({
                    url :'{{ url('cek_data_realisasi') }}',
                    dataType: "json"
                }).done(function (result) {
                    console.log(result);
                    table_laporan.clear().draw();
                    table_laporan.rows.add(result.data).draw();
                }).fail(function (jqHRX, textStatus, errorThrow) {

                });
            }

            setTimeout(function(){
                loadData()
                alert("Load Data selesai")
            }, 5000);

            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

             $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('print_laporan_perjenis_barang') }}',
                    type: 'post',
                    data : {
                        'tanggal_cetak':$('[name="tanggal_cetak"]').val(),
                        '_token' : '{{ csrf_token() }}'
                    },
                    success :function (data) {
                     console.log(data);
                      var newWin=window.open('','Print-Window');
                      newWin.document.open();
                      newWin.document.write(data);
                      newWin.document.close();
                    }
                })

            })

        });
    </script>
@stop