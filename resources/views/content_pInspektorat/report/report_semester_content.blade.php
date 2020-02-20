
@extends('master_p_inspektorat')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Laporan Semester
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
                        <h4 class="modal-title" id="title">Tabel Semester</h4>

                    </div>
                    <div class="box-body table-responsive">
                            <table id="example3"  class="custom_table">
                                <thead>
                                <tr>
                                    <th rowspan="3">No</th>
                                    <th rowspan="3">Terima Tanggal </th>
                                    <th rowspan="3">Dari</th>
                                    <th colspan="2">Dokumen Faktur </th>
                                    <th colspan="2">&nbsp;</th>
                                    <th rowspan="3">Banyak</th>
                                    <th rowspan="3">Nama Barang </th>
                                    <th rowspan="3">Harga Satuan (Rp) </th>
                                    <th colspan="2">Bukti Penerimaan </th>
                                    <th rowspan="3">Ket</th>
                                    <th rowspan="3">No. Urut </th>
                                    <th rowspan="3">Tanggal Pengeluaran </th>
                                    <th colspan="2">Surat Bon </th>
                                    <th rowspan="3">Untuk</th>
                                    <th rowspan="3">Banyaknya</th>
                                    <th rowspan="3">Nama Barang </th>
                                    <th rowspan="3">Harga satuan (Rp) </th>
                                    <th rowspan="3">Jumlah Harga (Rp) </th>
                                    <th rowspan="3">Tanggal Penyerahan </th>
                                    <th rowspan="3">Ket</th>
                                </tr>
                                <tr>
                                    <th rowspan="2">No.</th>
                                    <th rowspan="2">Tanggal.</th>
                                    <th rowspan="2">Jenis surat </th>
                                    <th rowspan="2">Nomor</th>
                                    <th colspan="2">B.A./Srt. Penerimaan </th>
                                    <th rowspan="2">No</th>
                                    <th rowspan="2">Tgl</th>
                                </tr>
                                <tr>
                                    <th >Nomor</th>
                                    <th >Tanggal</th>
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
                                    <th>15</th>
                                    <th>16</th>
                                    <th>17</th>
                                    <th>18</th>
                                    <th>19</th>
                                    <th>20</th>
                                    <th>21</th>
                                    <th>22</th>
                                    <th>23</th>
                                    <th>24</th>
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
                            <label for="inputEmail3" class="col-sm-6 control-label">Pilih Semester</label>
                            <div class="col-sm-12">
                                <input type="radio" name="sms" value="1"> <label style="padding-right: 1%">I</label>
                                <input type="radio" name="sms" value="2"> <label style="padding-right: 1%">II</label>
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
                    {'data':'4'},
                    {'data':'5'},
                    {'data':'6'},
                    {'data':'7'},
                    {'data':'8'},
                    {'data':'9'},
                    {'data':'10'},
                    {'data':'12'},
                    {'data':'13'},
                    {'data':'14'},
                    {'data':'15'},
                    {'data':'16'},
                    {'data':'17'},
                    {'data':'18'},
                    {'data':'19'},
                    {'data':'20'},
                    {'data':'21'},
                    {'data':'22'},
                    {'data':'23'},
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
                url :'{{ url('semester') }}',
                dataType: "json"
            }).done(function (result) {
                console.log(result);
                table_laporan.clear().draw();
                table_laporan.rows.add(result.data).draw();
                table_laporan.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
                table_laporan.column(13, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).fail(function (jqHRX, textStatus, errorThrow) {

            });

            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

            $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('print_report_semester') }}',
                    type: 'post',
                    data : {
                        'first_date':$('[name="first_date"]').val(),
                        'last_date' : $('[name="last_date"]').val(),
                        'print_date' : $('[name="print_date"]').val(),
                        'sms' : $('[name="sms"]').val(),
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