
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Laporan Kartu Barang
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
                        <h4 class="modal-title" id="title">Tabel Kartu Barang</h4>

                    </div>


                    <div class="box-body table-responsive">
                        <div style="margin-bottom: 2%">
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="goods_selecting">
                                <option>Pilih Barang</option>
                                @foreach($gudang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->goods_name.'|'.$barang->unit.'|'.$barang->specs.'|'.$barang->brand }}</option>
                                @endforeach
                            </select>
                        </div>
                            <table id="example3"  class="custom_table">
                                <thead>
                                <tr>
                                    <th >no</th>
                                    <th >Tanggal</th>
                                    <th >Masuk</th>
                                    <th >Keluar</th>
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
                            <label for="inputEmail3" class="col-sm-6 control-label">Tanggal Awal</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker1" class="form-control" name="first_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Tanggal Akhir</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker2" class="form-control" name="last_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Tanggal Cetak</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker3" class="form-control" name="print_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
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

            $('#datepicker2').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            $('#datepicker2').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })

            $('#datepicker3').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            $('#datepicker3').datepicker({
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
                ],
                rowCallback : function (row, data) {

                },
                pagging:true,
                ordering:false,
                info: false,
                processing:true,
                retrieve : true
            });

            $('[name="goods_selecting"]').change(function () {
                $.ajax({
                    url :'{{ url('get_kb') }}',
                    dataType: "json",
                    type: 'post',
                    data : {
                        'id_barang' : $(this).val(),
                        '_token' : '{{ csrf_token() }}'
                    }
                }).done(function (result) {
                    console.log(result);
                    table_laporan.clear().draw();
                    table_laporan.rows.add(result.data).draw();
                }).fail(function (jqHRX, textStatus, errorThrow) {

                });
            });



            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

            $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('set_kb') }}',
                    type: 'post',
                    data : {
                        'first_date':$('[name="first_date"]').val(),
                        'last_date' : $('[name="last_date"]').val(),
                        'print_date' : $('[name="print_date"]').val(),
                        'id_barang' : $('[name="goods_selecting"]').val(),
                        'ext' : $('[name="ext"]').val(),
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