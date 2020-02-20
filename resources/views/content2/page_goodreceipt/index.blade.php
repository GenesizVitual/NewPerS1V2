
@extends('master2')
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
                        <h3 class="box-title">{{ $tbk->number_tbk }}</h3>
                        <div class="box-tools pull-right">
                            <a href="#" onclick="call_modal_insert('{{ $tbk->id }}')" data-toggle="tooltip" title="Tambah Barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Barang Penerimaan</a>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive" style="padding-top: 1%">
                            {{--<div class="form-group">--}}
                                {{--<label for="inputEmail3" class="col-sm-3 control-label">Pilih Jenis Barang</label>--}}
                                {{--<div class="col-sm-12">--}}
                                    {{--<form action="{{ url('goodreceipt/'.$tbk->id.'/delete_by_jenis_barang') }}" method="post" style="padding-bottom: 3%;">--}}
                                        {{--<select class="form-control select2 select2-hidden-accessible" style="width: 100%; margin-bottom: 3%;" tabindex="-1" aria-hidden="true" name="jenis_barang">--}}
                                            {{--<option>Pilih Jenis Barang</option>--}}
                                            {{--@foreach($jenis_barang as $gudan)--}}
                                                {{--<option value="{{ $gudan->id }}">{{ $gudan->typeOfGoods }}</option>--}}
                                            {{--@endforeach--}}
                                        {{--</select>--}}
                                        {{--<input type="hidden" name="_method" value="put">--}}
                                        {{--{{ csrf_field() }}--}}
                                        {{--<button type="submit" class="btn btn-danger" style="margin-top: 10px;" >Hapus Berdasarkan Jenis barang</button>--}}
                                    {{--</form>--}}
                                {{--</div>--}}
                            {{--</div>--}}
                            <table id="example1" class="table table-bordered table-striped" style="width: 100%">
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
                                    <input type="text" id="datepicker" class="form-control" name="dateOfpurchase" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask >
                                    <span style="color: red">* Tidak boleh kosong</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                                <div class="col-sm-12">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="warehouse_id" >
                                        <option value="null">Pilih Barang</option>
                                        @foreach($gudang as $gudans)
                                            <option value="{{ $gudans->id }}">{{ $gudans->goods_name }} | {{ $gudans->unit }} | {{ $gudans->specs }} <p style="align: left"> Rp. {{ number_format($gudans->standard_price,2,'.',',') }} </p></option>
                                        @endforeach
                                    </select>
                                    <span style="color: red">* Tidak boleh kosong</span><br>
                                    <a href="{{ url('warehouse/create') }}" class="pull-rigt">Tambah Barang</a>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Quantitas</label>
                                <div class="col-sm-12">
                                    <input type="text" name="unitPrice" class="form-control" >
                                    <span style="color: red">* Tidak boleh kosong</span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Harga Barang</label>
                                <div class="col-sm-12">
                                    <input type="text" name="amountOfgoods" class="form-control" >
                                    <span style="color: red">* Tidak boleh kosong</span>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="inputEmail3" class="col-sm-3 control-label">Suplier</label>
                                <div class="col-sm-12">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="suppliers_id" >
                                        <option value="null">Pilih Supplier</option>
                                        @foreach($supplies as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->suppliers }}</option>
                                        @endforeach
                                    </select>
                                    <span style="color: red">* Tidak boleh kosong</span><br>
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
                                <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Faktur</label>
                                <div class="col-sm-12">
                                    <input type="text" name="date_factur" id="datepicker2" class="form-control" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                        <button type="button" id="tombol_tambah_penerimaan">Simpan</button>
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
                            <label for="inputEmail3" class="col-sm-3 control-label">TBK</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="tbk_id">
                                    @foreach($tbkAll as $data)
                                        <option value="{{ $data->id }}">{{ $data->number_tbk }} </option>
                                    @endforeach
                                </select>
                                <a href="{{ url('warehouse/create') }}">Tambah Barang</a><br>
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Tanggal Beli</label>
                            <div class="col-sm-12">
                                <input type="text" id="datepicker1" class="form-control" name="dateOfpurchase1" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Barang</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible"  style="width: 100%;" tabindex="-1" aria-hidden="true" id="warehouse_id1" name="warehouse_id1">
                                   @foreach($gudang as $gudans)
                                        <option value="{{ $gudans->id }}">{{ $gudans->goods_name }} | {{ $gudans->unit }} | | {{ $gudans->specs }} <p class="pull-right">Rp. {{ number_format($gudans->standard_price,2,'.',',') }}</p></option>
                                    @endforeach
                                </select>
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Quantitas</label>
                            <div class="col-sm-12">
                                <input type="text" name="amountOfgoods1" class="form-control">
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>

                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Barang</label>
                            <div class="col-sm-12">
                                <input type="text" name="unitPrice1" class="form-control">
                                <span style="color: red">* Tidak boleh kosong</span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Suplier</label>
                            <div class="col-sm-12">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="suppliers_id1">
                                    @foreach($supplies as $supplier2)
                                        <option value="{{ $supplier2->id }}">{{ $supplier2->suppliers }}</option>
                                    @endforeach
                                </select>
                                <span style="color: red">* Tidak boleh kosong</span>
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
                   format: 'dd-mm-yyyy',
                   defaultDate : null
               })
               $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker1').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy',
                   defaultDate : null
               })

               $('#datepicker2').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker2').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy',
                   defaultDate : null
               })

               $('#datepicker3').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

               //Date picker
               $('#datepicker3').datepicker({
                   autoclose: true,
                   format: 'dd-mm-yyyy',
                   defaultDate : null
               })

               call_modal_insert = function(tbk_id){
                   id_tbk=tbk_id;
                   $('#modal-penerimaan_tambah').modal('show');
               }

               $('#tombol_tambah_penerimaan').click(function (e) {
                   //e.preventDefault();
                   if(isValidForm()){
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
                   }

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
                            var yer = data.dataForm.dateOfpurchase
                            $('[name="dateOfpurchase1"]').val(date.getDate()+'-'+parseInt(date.getMonth()+1)+'-'+yer.split("-")[0]);
                            $('[name="warehouse_id1"]').val(""+data.dataForm.warehouse_id).trigger('change');
                            $('[name="suppliers_id1"]').val(""+data.dataForm.suppliers_id).trigger('change');
                            $('[name="tbk_id"]').val(""+data.dataForm.tbk_id).trigger('change');
                            $('[name="unitPrice1"]').val(data.dataForm.unitPrice);
                            $('[name="amountOfgoods1"]').val(data.dataForm.amountOfgoods);
                            if(data.dataForm.date_factur!='1970-01-01')
                            {
                                var pecah_tanggal = data.dataForm.date_factur;
                                if(pecah_tanggal != null){
                                    var tanggals = pecah_tanggal.split("-");
                                    $('[name="date_factur1"]').val(tanggals[2]+"-"+tanggals[1]+"-"+tanggals[0]);
                                }else{
                                    $('[name="date_factur1"]').val("");
                                }
                                //tanggal_faktur= tanggals.getDate()+'-'+parseInt(tanggals.getMonth()+1)+'-'+tanggals.getYear();
                            }


                            $('[name="no_factur1"]').val(data.dataForm.nomor_factur);

                            $('#modal-penerimaan_ubah').modal('show');
                        },
                        error : function () {
                            alert("Gagal mengambil data barang");
                        }
                    })
               }

               $('#tombol_ubah_penerimaan').click(function (e) {

                   if(isValidFormUpdate()){
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
                               'tbk_id': $('[name="tbk_id"]').val(),
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
                   }
               })

               delete_goods = function(id){
                   if(confirm('Apa anda akan menghapus barang ini ... ?'+id) == true){
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

               isValidForm = function () {
                   var dateOfpurchase=$('[name="dateOfpurchase"]').val();
                   var warehouse_id=$('[name="warehouse_id"]').val();
                   var amountOfgoods=$('[name="amountOfgoods"]').val();
                   var unitPrice=$('[name="unitPrice"]').val();
                   var suppliers_id=$('[name="suppliers_id"]').val();
                   console.log(dateOfpurchase);
                   console.log(warehouse_id);
                   console.log(amountOfgoods);
                   console.log(unitPrice);
                   console.log(suppliers_id);
                   if(dateOfpurchase == ""){
                       alert("Tanggal Penerimaan Tidak Boleh Kosong");
                       return false;
                   }
                   if(warehouse_id == "null"){
                       alert("Barang Tidak Boleh Kosong");
                       return false;
                   }
                   if(amountOfgoods == ""){
                       alert("Quantitas Barang Tidak Boleh Kosong");
                       return false;
                   }
                   if(unitPrice == ""){
                       alert("Harga Barang Tidak Boleh Kosong");
                       return false;
                   }
                   if(suppliers_id == "null"){
                       alert("Supplier Tidak Boleh Kosong");
                       return false;
                   }
                   return true;
               }

               isValidFormUpdate = function () {
                   var dateOfpurchase=$('[name="dateOfpurchase1"]').val();
                   var warehouse_id=$('[name="warehouse_id1"]').val();
                   var amountOfgoods=$('[name="amountOfgoods1"]').val();
                   var unitPrice=$('[name="unitPrice1"]').val();
                   var suppliers_id=$('[name="suppliers_id1"]').val();
                   console.log(dateOfpurchase);
                   console.log(warehouse_id);
                   console.log(amountOfgoods);
                   console.log(unitPrice);
                   console.log(suppliers_id);
                   if(dateOfpurchase == ""){
                       alert("Tanggal Penerimaan Tidak Boleh Kosong");
                       return false;
                   }
                   if(warehouse_id == "null"){
                       alert("Barang Tidak Boleh Kosong");
                       return false;
                   }
                   if(amountOfgoods == ""){
                       alert("Quantitas Barang Tidak Boleh Kosong");
                       return false;
                   }
                   if(unitPrice == ""){
                       alert("Harga Barang Tidak Boleh Kosong");
                       return false;
                   }
                   if(suppliers_id == "null"){
                       alert("Supplier Tidak Boleh Kosong");
                       return false;
                   }
                   return true;
               }

           })
       </script>
@stop
