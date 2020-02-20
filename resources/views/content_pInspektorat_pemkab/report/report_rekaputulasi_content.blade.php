
@extends('master_p_inspektorat_pemkab')
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
                        <!-- form start -->

                            <div class="box-body">
                                <button type="button" onclick="show_report_setting()" class="btn btn-primary">Print Rekapitulasi</button>

                                <p></p>
                                <p></p>
                                <table class="table table-bordered table-striped dataTable">
                                    <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>DPA</th>
                                        <th>Jumlah</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @php($i=1)
                                    @if(!empty($listSpj))
                                        @foreach($listSpj as $spj)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $spj->number_spj }}</td>
                                            <td> @foreach($totals_spj as $bd)
                                                    @if($spj->id==$bd->spj_id)
                                                       Rp. {{ number_format($bd->totalSJP,2,'.','.') }}
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>

                                            @if(!empty($spj->getTbk))
                                                @foreach($spj->getTbk as $test)
                                                    <tr>
                                                        <td></td>
                                                        <td>{{ $test->number_tbk }}</td>
                                                        <td> @if(!empty($test->getSumReciept->sum('totalPrice')) ) Rp. {{ number_format($test->getSumReciept->sum('totalPrice'),2,'.','.') }} @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif

                                        @endforeach
                                    @endif
                                    <tr>
                                        <th colspan="2">Jumlah DPA</th>
                                        <th>
                                            @if(!empty($dpa->pagu_value))
                                                Rp {{ number_format($dpa->pagu_value,2,'.','.') }}
                                            @else
                                                Rp {{ number_format(0,2,'.','.') }}
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Jumlah Yang Terpakai</th>
                                        <th>
                                            @if(!empty($jumlah_spj))
                                                Rp {{ number_format($jumlah_spj,2,'.','.') }}
                                            @else
                                                Rp {{ number_format(0,2,'.','.') }}
                                            @endif
                                        </th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">Sisa DPA</th>
                                        <th>
                                            @if(!empty($dpa->pagu_value))
                                                Rp {{ number_format($dpa->pagu_value-$jumlah_spj,2,'.','.') }}
                                            @else
                                                Rp {{ number_format(0,2,'.','.') }}
                                            @endif
                                        </th>
                                    </tr>
                                    </tbody>
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

            show_report_setting = function(){
                $('#modal-report-setting').modal({backdrop:'static', keyboard:false});
            }

            $('#proses_print').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url: '{{ url('report_rekap_spj_print') }}',
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