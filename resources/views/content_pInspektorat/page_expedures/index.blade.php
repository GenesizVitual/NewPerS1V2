
@extends('master_p_inspektorat')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Kelola Penerimaan barang
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabel Penerimaan Barang</h3>
                    </div>
                    <div class="box-body">
                        <div>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="goods_selecting">
                                <option>Pilih Barang</option>
                                @foreach($gudang as $barang)
                                    <option value="{{ $barang->id }}">{{ $barang->goods_name.'|'.$barang->unit.'|'.$barang->specs.'|'.$barang->brand }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Tanggal Penerimaan</th>
                                            <th>Nama Barang</th>
                                            <th>Quantitas</th>
                                            <th>Harga Barang</th>
                                            <th>Supplier</th>
                                            <th>Aksi</th>
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

    @php($bidangs = $bidang)
    <!-- Modal Pengeluaran Barang-->
    <div class="modal fade" id="modal-pengeluaran" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title">Formulir Pengeluaran barang</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group" id="notifikasi">
                            <label for="inputEmail3" class="col-sm-12 control-label" style="color: red">*Stok Barang Sudah tidak mencukupi</label>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-6 control-label">Tanggal Barang keluar</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker1" class="form-control" name="out_date" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Jumlah keluar</label>
                            <div class="col-sm-12">
                                <input type="text" name="exit_item" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Bidang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="sector_id">
                                    <option>Pilih Bidang</option>
                                    @if(!empty($bidangs))
                                        @foreach($bidangs as $bid)
                                            <option value="{{ $bid->id }}">{{ $bid->sector_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Keterangan</label>
                            <div class="col-sm-12">
                                <input type="text" name="information" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_pengeluaran">Proses</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <div class="modal fade" id="modal-data-pengeluaran" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="title">Tabel pengeluaran</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example3" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal Pengeluaran</th>
                                    <th>Nama Barang</th>
                                    <th>Quantitas</th>
                                    <th>Bidang</th>
                                    <th>Information</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Tutup</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

@stop

@section('jsContainer')

    <script>

        jQuery.fn.dataTableExt.oSort['string-case-asc']  = function(x,y) {
            return ((x < y) ? -1 : ((x > y) ?  1 : 0));
        };

        jQuery.fn.dataTableExt.oSort['string-case-desc'] = function(x,y) {
            return ((x < y) ?  1 : ((x > y) ? -1 : 0));
        };


        $(document).ready(function(){

            $('#notifikasi').hide();

            $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })
            var id_receipt;
            var id_goods;
            var stok_max;
            //Date picker
            $('#datepicker1').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })


            table_penerimaan = $('#example1').DataTable({
                data:[],

                column:[
                    {'data' :'0'},
                    {'data' :'1'},
                    {'data' :'2'},
                    {'data' :'3'},
                    {'data' :'4'},
                    {'data' :'5'},
                ],
                rowCallback : function(row, data){

                },
                filter: false,
                pagging : true,
                searching: true,
                info : true,
                ordering : true,
                processing : true,
                retrieve: true
            });

            call_data = function (data) {
                $.ajax({
                    url: '{{ url('expendures') }}/'+data,
                    dataType : 'json',
                    data :{
                        '_token' : '{{ csrf_token() }}'
                    }
                }).done(function (result) {
                    console.log(result);
                    table_penerimaan.clear().draw();
                    table_penerimaan.rows.add(result.data).draw();
                    $('#title').text(result.barang+' | '+result.specs);
                }).fail(function(jqXHR, textStatus,errorThrown){

                })
            }
            
            call_data_expendures = function (id) {
                $.ajax({
                    url:'{{ url('expendures') }}/'+id+'/out_item',
                    dataType: 'json',
                    data:{
                        '_token' : '{{ csrf_token() }}'
                    }
                }).done(function (result) {
                    console.log(result);
                    table_pengeluaran.clear().draw();
                    table_pengeluaran.rows.add(result.data).draw();

                    $('#modal-data-pengeluaran').modal({backdrop: 'static', keyboard: false});
                }).fail(function (jqXHR, textStatus,errorThrow) {
                    
                })
            }

            table_pengeluaran = $('#example3').DataTable({
                data:[],
                column:[
                    {'data' :'0'},
                    {'data' :'1'},
                    {'data' :'2'},
                    {'data' :'3'},
                    {'data' :'4'},
                    {'data' :'5'},
                    {'data' :'6'},
                ],
                rowCallback : function(row, data){

                },
                filter: false,
                pagging : true,
                searching: true,
                info : true,
                ordering : true,
                processing : true,
                retrieve: true
            });

            $('[name="goods_selecting"]').change(function () {
               call_data($(this).val());
            })


            exit_item = function (reciept_id, goods_id, max_stock) {
                id_receipt=reciept_id;
                id_goods=goods_id;
                stok_max=max_stock;
                console.log(id_receipt+"----"+id_receipt+"-----------"+stok_max);
                $('[name="exit_item"]').val(stok_max);
                $('#modal-pengeluaran').modal('show');
            }

            recover_receipt = function(id){
                if(confirm('Apakah anda ingin membatalkan pengeluaran untuk barang ini ...?')==true)
                {
                    $.ajax({
                        url: '{{ url('expendures') }}/'+id+'/recover',
                        type: 'post',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            '_method': 'put'
                        },
                        success: function(data){
                            console.log(data);
                           // call_data_expendures(data.receipt);
                            $('[name="exit_item"]').val('');
                            call_data(data.goods);
                            $('#modal-data-pengeluaran').modal('hide');
                            alert('Pengeluaran dibatalakan');
                        },
                        error : function(jqXHR, textStatus,errorThrow){
                            alert('Gagal membatalkan pengeluaran');
                        }
                    })
                }else{
                    alert('proses di batalkan');
                }
            }

            $('[name="exit_item"]').on('input', function () {
                console.log(stok_max);
                if($(this).val() > stok_max){
                    $('#tombol_pengeluaran').prop('disabled', true);
                    $('#notifikasi').show();
                }else{
                    $('#notifikasi').hide();
                    $('#tombol_pengeluaran').prop('disabled', false);
                }
            })

            $('#tombol_pengeluaran').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url : '{{ url('expendures') }}/store',
                    method: 'post',
                    data: {
                        '_token':'{{ csrf_token() }}',
                        'out_date': $('[name="out_date"]').val(),
                        'goodreceipt_id': id_receipt,
                        'warehouse_id':id_goods,
                        'exit_item':$('[name="exit_item"]').val(),
                        'sector_id':$('[name="sector_id"]').val(),
                        'information':$('[name="information"]').val()
                    },
                    success:function(data){
                        console.log(data);
                        $('[name="exit_item"]').val('');
                        alert(data.info);
                        $('#modal-pengeluaran').modal('hide');
                        call_data(id_goods);
                    },
                    error: function () {
                        alert('barang gagal dikeluarkan');
                    }
                })
            })

        })
    </script>

@stop