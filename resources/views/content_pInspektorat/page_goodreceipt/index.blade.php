
@extends('master_p_inspektorat')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Penerimaan Barang
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
                        <h3 class="box-title">Tabel Penerimaan</h3>
                        <div class="box-tools pull-right">
                            <a href="#" onclick="call_modal_insert('{{ $tbk->id }}')" data-toggle="tooltip" title="Tambah Barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Barang Penerimaan</a>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal beli</th>
                                    <th>Barang</th>
                                    <th>Banyak barang </th>
                                    <th>Harga Barang</th>
                                    <th>Supplier</th>
                                    <th>Total harga barang</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($goodreceipt as $data)
                                    <tr>
                                        <th>{{ $i++ }}</th>
                                        <th>{{ date('d-m-Y',strtotime($data->dateOfpurchase)) }}</th>
                                        <th>{{ $data->getGoods->goods_name }} | {{ $data->getGoods->specs }}</th>
                                        <th>
                                          @if(!empty($data->getExpendures->where('goodreceipt_id', $data->id)->exit_item))
                                            {{ number_format($data->amountOfgoods - $data->getExpendures->where('goodreceipt_id', $data->id)->sum(exit_item),2,',','.') }}
                                          @else
                                            {{ number_format($data->amountOfgoods,2,',','.') }}
                                          @endif


                                        </th>
                                        <th>{{ number_format($data->unitPrice,2,',','.') }}</th>
                                        <th>{{ $data->getSupplier->suppliers }}</th>
                                        <th>{{ number_format($data->totalPrice,2,',','.') }}</th>
                                        <th>
                                            <a href="#" onclick="call_modal_edit('{{ $tbk->id }}','{{ $data->id }}')" class="btn btn-warning">ubah</a>
                                            <button type="submit" class="btn btn-danger" onclick="delete_goods('{{ $data->id }}')">hapus</button>

                                        </th>
                                    </tr>
                                @endforeach
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

    @php($supplies = $supplier)

    <!-- Modal Tambah TBK -->
    <div class="modal fade" id="modal-penerimaan_tambah" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Barang Penerimaan</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Beli</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker" class="form-control" name="dateOfpurchase" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="warehouse_id">
                                    <option>Pilih Barang</option>
                                    @foreach($gudang as $gudans)
                                        <option value="{{ $gudans->id }}">{{ $gudans->goods_name }} | {{ $gudans->unit }} | {{ $gudans->specs }}</option>
                                    @endforeach
                                </select>
                                <a href="{{ url('warehouse/create') }}">Tambah Barang</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Quantitas</label>
                            <div class="col-sm-12">
                                <input type="text" name="unitPrice" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Barang</label>
                            <div class="col-sm-12">
                                <input type="text" name="amountOfgoods" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Suplier</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="suppliers_id">
                                    <option>Pilih Supplier</option>
                                    @foreach($supplies as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->suppliers }}</option>
                                    @endforeach
                                </select>                                
                                <a href="{{ url('suppliers/create') }}">Tambah Supplier</a>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">No Faktur</label>
                            <div class="col-sm-12">
                                <input type="text" name="no_factur" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">No Faktur</label>
                            <div class="col-sm-12">
                                <input type="text" name="date_factur" id="datepicker2" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_tambah_penerimaan">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal ubah TBK -->
    <div class="modal fade" id="modal-penerimaan_ubah" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ubah Barang Penerimaan</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Beli</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker1" class="form-control" name="dateOfpurchase1" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible"  style="width: 100%;" tabindex="-1" aria-hidden="true" id="warehouse_id1" name="warehouse_id1">
                                    <option value="0">Semua Barang</option>
                                    @foreach($gudang as $gudans)
                                        <option value="{{ $gudans->id }}">{{ $gudans->goods_name }} | {{ $gudans->unit }} | | {{ $gudans->specs }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Quantitas</label>
                            <div class="col-sm-12">
                                <input type="text" name="amountOfgoods1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Barang</label>
                            <div class="col-sm-12">

                                <input type="text" name="unitPrice1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Suplier</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="suppliers_id1">
                                    <option>Pilih Supplier</option>
                                    @foreach($supplies as $supplier2)
                                        <option value="{{ $supplier2->id }}">{{ $supplier2->suppliers }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">No Faktur</label>
                            <div class="col-sm-12">
                                <input type="text" name="no_factur1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Faktur</label>
                            <div class="col-sm-12">
                                <input type="text" name="date_factur1" id="datepicker3" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_ubah_penerimaan">Simpan</button>
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
           $(document).ready(function () {
                var id_tbk;
                var id_goods;
               $('#datepicker').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy'
               })
               $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker1').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy'
               })

               $('#datepicker2').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker2').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy'
               })

               $('#datepicker3').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker3').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy'
               })

               call_modal_insert = function(tbk_id){
                   id_tbk=tbk_id;
                   $('#modal-penerimaan_tambah').modal('show');
               }

               $('#tombol_tambah_penerimaan').click(function (e) {
                   e.preventDefault();

                   $.ajax({
                       url: "{{ url('goodreceipt') }}/"+id_tbk+'/list',
                       type: "post",
                       data: {
                           '_method': 'put',
                           '_token': '{{ csrf_token() }}',
                           'dateOfpurchase' : $('[name="dateOfpurchase"]').val(),
                           'warehouse_id': $('[name="warehouse_id"]').val(),
                           'unitPrice' : $('[name="amountOfgoods"]').val(),
                           'amountOfgoods':$('[name="unitPrice"]').val(),
                           'suppliers_id': $('[name="suppliers_id"]').val(),
                           'no_factur': $('[name="no_factur"]').val(),
                           'date_factur': $('[name="date_factur"]').val(),
                       },
                       success: function(feetback){
                           $('#modal-penerimaan_tambah').modal('hide');
                           alert(feetback.info);
                           window.location.reload();
                       },
                       error : function () {
                           alert('Barang gagal disimpan');
                       }
                   })

               })

               call_modal_edit = function(tbk_id, goods_id){
                   id_tbk=tbk_id;
                   id_goods = goods_id;
                   var tanggal_faktur='';
                   var date='';
                    $.ajax({
                        url: "{{ url('goodreceipt') }}/"+tbk_id+'/'+goods_id+'/list',
                        dataType: "json",
                        success: function (data) {
                            date = new Date(data.dataForm.dateOfpurchase);
                            console.log(date.getMonth());
                            $('[name="dateOfpurchase1"]').val(date.getDate()+'-'+parseInt(date.getMonth()+1)+'-'+date.getYear());
                            $('[name="warehouse_id1"]').val(""+data.dataForm.warehouse_id).trigger('change');
                            $('[name="suppliers_id1"]').val(""+data.dataForm.suppliers_id).trigger('change');
                            $('[name="unitPrice1"]').val(data.dataForm.unitPrice);
                            $('[name="amountOfgoods1"]').val(data.dataForm.amountOfgoods);
                            if(data.dataForm.date_factur!='1970-01-01')
                            {
                                var tanggals = new Date(data.dataForm.date_factur);
                                tanggal_faktur= tanggals.getDate()+'-'+parseInt(tanggals.getMonth()+1)+'-'+tanggals.getYear();
                            }

                            $('[name="no_factur1"]').val(data.dataForm.nomor_factur);
                            $('[name="date_factur1"]').val(tanggal_faktur);
                            $('#modal-penerimaan_ubah').modal('show');
                        },
                        error : function () {
                            alert("Gagal mengambil data barang");
                        }
                    })
               }

               $('#tombol_ubah_penerimaan').click(function (e) {
                   $.ajax({
                       url:"{{ url('goodreceipt') }}/"+id_goods+"/update",
                       type: "post",
                       data :{
                           '_method': 'put',
                           '_token': '{{ csrf_token() }}',
                           'dateOfpurchase' : $('[name="dateOfpurchase1"]').val(),
                           'warehouse_id': $('[name="warehouse_id1"]').val(),
                           'unitPrice' : $('[name="unitPrice1"]').val(),
                           'amountOfgoods':$('[name="amountOfgoods1"]').val(),
                           'suppliers_id': $('[name="suppliers_id1"]').val(),
                           'no_factur': $('[name="no_factur1"]').val(),
                           'date_factur': $('[name="date_factur1"]').val(),
                       },
                       success : function(data){
                           alert('Data permintaan barang berhasil di ubah');
                           console.log(data);
                           window.location.reload();
                       },
                       error: function () {
                           alert('Data tidak bisa diubah');
                       }
                   });
               })

               delete_goods = function(id){
                   if(confirm('Apa anda akan menghapus barang ini ... ?') == true){
                       $.ajax({
                           url:"{{ url('goodreceipt') }}/"+id+"/delete",
                           method: 'post',
                           data:{
                               '_method': 'put',
                               '_token': '{{ csrf_token() }}',
                           },
                           success: function (data) {
                             // alert(feetback.info);
                             // console.log(data);
                             window.location.reload();
                           }
                       })
                   }else{
                       alert('proses hapus dibatalkan');
                   }
               }



           })
       </script>
@stop
