
@extends('master_p_inspektorat_pemkab')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Laporan Barang Pakai Habis
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
                        <h4 class="modal-title" id="title">Tabel Barang pakai habis</h4>

                    </div>
                    <div class="box-body table-responsive">
                            <table id="example3"  class="custom_table">
                                <thead>
                                <tr>
                                    <th rowspan="2">no</th>
                                    <th rowspan="2">Tanggal terima </th>
                                    <th rowspan="2">Jenis Atau nama barang </th>
                                    <th rowspan="2">Merek/ukuran</th>
                                    <th rowspan="2">tahun pembuatan </th>
                                    <th rowspan="2">jumlah satuan/barang </th>
                                    <th rowspan="2">tgl/no.kontak/sp/spk/harga satuan </th>
                                    <th colspan="2">berita acara </th>
                                    <th rowspan="2">tanggal dikeluarkan </th>
                                    <th rowspan="2">diserahkan kepada </th>
                                    <th rowspan="2">jumlah satuan/barang </th>
                                    <th rowspan="2">tanggal/no. surat penyerahan </th>
                                    <th rowspan="2">keterangan</th>
                                </tr>
                                <tr>
                                    <th >tanggal</th>
                                    <th >nomor</th>
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
                                    <th>11</th>
                                    <th>12</th>
                                    <th>13</th>
                                    <th>14</th>
                                </tr></thead>
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
                    {'data':'4'},
                    {'data':'5'},
                    {'data':'6'},
                    {'data':'7'},
                    {'data':'8'},
                    {'data':'9'},
                    {'data':'10'},
                    {'data':'12'},
                    {'data':'13'},
                ],
                rowCallback : function (row, data) {

                },
                pagging:true,
                ordering:false,
                info: false,
                processing:true,
                retrieve : true
            });

            $.ajax({
                url :'{{ url('bph') }}',
                dataType: "json"
            }).done(function (result) {
                console.log(result);
                table_laporan.clear().draw();
                table_laporan.rows.add(result.data).draw();
            }).fail(function (jqHRX, textStatus, errorThrow) {

            });

            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

            $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('bph/post') }}',
                    type: 'post',
                    data : {
                        'first_date':$('[name="first_date"]').val(),
                        'last_date' : $('[name="last_date"]').val(),
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