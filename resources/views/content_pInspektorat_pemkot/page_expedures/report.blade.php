
@extends('master_p_inspektorat_pemkot')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Laporan Pengeluaran
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
                        <h4 class="modal-title" id="title">Tabel Pengeluaran</h4>

                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <table id="example3"  class="custom_table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal keluar</th>
                                        <th>No Urut</th>
                                        <th>Nama Barang</th>
                                        <th>Banyaknya</th>
                                        <th>Harga Satuan(Rp)</th>
                                        <th>Jumlah Harga (Rp)</th>
                                        <th>Untuk</th>
                                        <th>Tanggal Penyerahan</th>
                                        <th>Keterangan</th>
                                    </tr>
                                    <tr>
                                        <th>1</th>
                                        <th>2</th>
                                        <th>3</th>
                                        <th>4</th>
                                        <th>5</th>
                                        <th>6</th>
                                        <th>7</th>
                                        <th>8</th>
                                        <th>9</th>
                                        <th>10</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
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
                            <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="warehouse_id1">
                                    <option>Pilih Barang</option>
                                    @foreach($gudang as $gudans)
                                        <option value="{{ $gudans->id }}">{{ $gudans->goods_name }} | {{ $gudans->unit }} | {{ $gudans->specs }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Tanggal cetak</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker3" class="form-control" name="print_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Format Print</label>
                            <div class="col-sm-12">
                                <input type="radio" name="ext" value="1"> <label style="padding-right: 1%">Print Langsung</label>
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
                "order": [1, 'asc'],
                "columnDefs": [
                    { className: "no", "targets": [0] },
                    { className: "joker", "targets": [2] },
                    { className: "dateOut", "targets": [1], "order":'asc'},
                ],
                column : [
                    {'data':'0'},
                    {'data':'1'},
                    {'data':'2'},
                    {'data':'3'},
                    {'data':'4'},
                    {'data':'5'},
                    {'data':'6'},
                    {'data':'7'},
                    {'data':'8'},
                    {'data':'9'},
                ],
                rowCallback : function (row, data) {

                },
                pagging:true,
                ordering:false,
                info: false,
                processing:true,
                retrieve : true
            });

            make_serial_number=function(){
                $('.no').each(function(idx, element){
                    //console.log(idx);
                    if(idx==0){
                    }else{
                        $(this).text(idx);
                    }
                });

                $('.joker').each(function(idx, element){
                    console.log(idx);
                    if(idx==0){
                    }else{
                        $(this).text(idx);
                    }
                });
            }

            $.ajax({
                url :'{{ url('report_expendures') }}',
                dataType: "json"
            }).done(function (result) {
                console.log(result);
                table_laporan.clear().draw();
                table_laporan.rows.add(result.data).draw();
                table_laporan.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
                table_laporan.column(2, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                    cell.innerHTML = i+1;
                } );
            }).fail(function (jqHRX, textStatus, errorThrow) {

            });

            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

            $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('report_receipt_exp') }}',
                    type: 'post',
                    data : {
                        'first_date':$('[name="first_date"]').val(),
                        'last_date' : $('[name="last_date"]').val(),
                        'warehouse_id1' : $('[name="warehouse_id1"]').val(),
                        'print_date' : $('[name="print_date"]').val(),
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