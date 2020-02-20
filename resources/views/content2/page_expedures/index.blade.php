
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Barang Masih tersedia</a></li>
                <li><a href="#tab_2-2" data-toggle="tab">Barang Telah Habis dikeluarkan</a></li>
                <li class="pull-left header"><i class="fa fa-th"></i>Kelola Barang</li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div>
                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="goods_selecting">
                            <option>Pilih Barang</option>
                            @foreach($gudang as $barang)
                                <option value="{{ $barang->id }}">{{ $barang->goods_name.'|'.$barang->unit.'|'.$barang->specs.'|'.$barang->brand }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="table-responsive" style="padding-top: 1%">
                        <p style="color: green">*Jika barang mempunyai stok dan tidak muncul berarti anda belum melakukan import stok barang pada menu stok barang</p>

                        <table id="example1" class="table table-bordered table-striped" style="width: 100%">
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
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2-2">
                    <div class="table-responsive" style="padding-top: 1%">

                        <table id="example1_habis" class="table table-bordered table-striped" style="width: 100%">
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
                    </div>.
                </div>
                <!-- /.tab-pane -->

                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>


        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
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
                                <span style="color: red" id="notif_tgl">*Tidak boleh kosong dan Tanggal Barang keluar harus lebih besar atau sama dengan tanggal penerimaan</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Jumlah keluar</label>
                            <div class="col-sm-12">
                                <input type="text" name="exit_item" class="form-control">
                                <span style="color: red">*Tidak boleh kosong</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Bidang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="sector_id">
                                    <option value="null">Pilih Bidang</option>
                                    @if(!empty($bidangs))
                                        @foreach($bidangs as $bid)
                                            <option value="{{ $bid->id }}">{{ $bid->sector_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                                <span style="color: red">*Tidak boleh kosong</span>
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
                    <button type="button" class="btn btn-primary" id="tombol_pengeluaran"><i class="fa fa-fw fa-archive" id="icon_reloading"></i> Proses </button>
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
            var title_barang;
            var spek_barang;
            var id_stok_barangs;
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

            table_penerimaan_habis = $('#example1_habis').DataTable({
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
                }).done(function (result) {
                    console.log(result);
                    call_data_habis(data);
                    table_penerimaan.clear().draw();
                    table_penerimaan.rows.add(result.data).draw();
                    $('#title').text(result.barang+' | '+result.specs);
                    title_barang = result.barang;
                    spek_barang = result.specs;
                }).fail(function(jqXHR, textStatus,errorThrown){

                })
            }

            call_data_habis = function (data) {
                $.ajax({
                    url: '{{ url('expendures_habis') }}/'+data,
                    dataType : 'json',
                }).done(function (result) {
                    console.log(result);
                    table_penerimaan_habis.clear().draw();
                    table_penerimaan_habis.rows.add(result.data).draw();
                    $('#title').text(result.barang+' | '+result.specs);
                }).fail(function(jqXHR, textStatus,errorThrown){

                })
            }
            
            call_data_expendures = function (id) {
                $.ajax({
                    url:'{{ url('expendures') }}/'+id+'/out_item',
                    dataType: 'json',
                }).done(function (result) {
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
               // call_data_habis($(this).val());
            })

           ;
            exit_item = function (reciept_id, goods_id, max_stock, id_stok_barang, tanggal_filter) {
                id_receipt=reciept_id;
                id_goods=goods_id;
                stok_max=max_stock;
                id_stok_barangs = id_stok_barang;


                $('[name="exit_item"]').val(stok_max);
                $('#title').text(title_barang+' | '+spek_barang);
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
                            $('[name="exit_item"]').val('');
                            call_data(data.goods);
                            //call_data_habis(data.goods);
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
                reload();
                e.preventDefault();
                if(isValidForm())
                {
                    $.ajax({
                        url : '{{ url('expendures') }}/store',
                        method: 'post',
                        data: {
                            '_token':'{{ csrf_token() }}',
                            'out_date': $('[name="out_date"]').val(),
                            'goodreceipt_id': id_receipt,
                            'id_stok_barangs': id_stok_barangs,
                            'warehouse_id':id_goods,
                            'exit_item':$('[name="exit_item"]').val(),
                            'sector_id':$('[name="sector_id"]').val(),
                            'information':$('[name="information"]').val()
                        },
                        success:function(data){
                            console.log(data);
                            unreaload();
                            $('[name="exit_item"]').val('');
                            alert(data.info);
                            $('#modal-pengeluaran').modal('hide');
                            call_data(id_goods);

                            //call_data_habis(id_goods);
                        },
                        error: function () {
                            alert('barang gagal dikeluarkan');
                        }
                    })
                }
            })

            reload=function(){
                $("#icon_reloading").attr('class', 'fa fa-refresh fa-spin');
            }

            unreaload=function(){
                $("#icon_reloading").attr('class', 'fa fa-fw fa-archive');
            }

            $('[name="out_date"]').change(function(){
                var tanggal_keluar = $(this).val();

                var tgl_stok

                if($('[name="tgl_stok_lama"]').val() != undefined){
                    tgl_stok = $('[name="tgl_stok_lama"]').val();
                }
                if($('[name="tgl_stok_baru"]').val() != undefined){
                    tgl_stok = $('[name="tgl_stok_baru"]').val();
                }
                var tanggal_penerimaan = tgl_stok;


                var convert_tgl_keluar = tanggal_keluar.split("-");
                var tgl1 = convert_tgl_keluar[2]+"/"+convert_tgl_keluar[1]+"/"+convert_tgl_keluar[0];


                var convert_tanggal_penerimaan = tanggal_penerimaan.split("-");
                var tgl2 = convert_tanggal_penerimaan[2]+"/"+convert_tanggal_penerimaan[1]+"/"+convert_tanggal_penerimaan[0];


                 if(tgl2 > tgl1){
                    $('#notif_tgl').text("Tanggal Keluar Tidak Boleh Lebih Kecil Dari Tanggal Penerimaan");
                    $('#tombol_pengeluaran').attr('disabled',true);
                }else{
                   // console.log(wokeh_terima.getMonth());
                   // console.log(tgl2+"========"+tgl1);
                    $('#notif_tgl').text("");
                    $('#tombol_pengeluaran').attr('disabled',false);
                }

            });

            isValidForm = function () {
                var out_date=$('[name="out_date"]').val();
                var exit_item=$('[name="exit_item"]').val();
                var sector_id=$('[name="sector_id"]').val();
                console.log(out_date);
                console.log(exit_item);
                console.log(sector_id);
                if(out_date == ""){
                    alert("Tanggal Barang Keluar Tidak Boleh Kosong");
                    return false;
                }
                if(exit_item == "null"){
                    alert("Barang Keluar Tidak Boleh Kosong");
                    return false;
                }
                if(sector_id == "null"){
                    alert("Bidang Tidak Boleh Kosong");
                    return false;
                }

                return true;
            }


        })
    </script>

@stop