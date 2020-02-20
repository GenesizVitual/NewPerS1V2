
@extends('master_p_bpk')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Laporan Realisasi Barang Pakai Habis
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="modal-header">
                        <div class="box-tools pull-right">
                        <button type="button" class="pull-right btn btn-default" onclick="show_report_setting()">
                                <i class="fa fa-fw fa-print"></i>
                            </button>
                        </div>
                        <h4 class="modal-title" id="title">Tabel Realisasi Barang Pakai Habis</h4>
                    </div>
                    <div class="box-body table-responsive">
                            <table id="example3"   class="custom_table">
                                <thead>
                                <tr>
                                    <th >No</th>
                                    <th >Kode Rekening</th>
                                    <th >Uraian</th>
                                    <th >Jumlah</th>
                                    <th >Digunakan</th>
                                    <th >Sisa</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                    </div>
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

            setTimeout(function() {
                loadData()
                alert("Load Data Selesai")
            }, 2000);

            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

             $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('cetak_realisasi_pakai_habis') }}',
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