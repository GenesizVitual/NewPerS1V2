
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Belanja DPA
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
                        <h3 class="box-title">Tabel Belanja Pada {{ $keg->keg_name}} </h3>
                        <div class="box-tools pull-right">
                            
                            {{--<a href="#" onclick="call_modal_insert('{{ $keg->id }}')" data-toggle="tooltip" title="Tambah Belanja" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Belanja</a>--}}
                             
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                   <th>#</th>
                                    <th>Kode Rekening</th>
                                    <th>Uraian</th>
                                    <th>Volume</th>
                                    <th>Satuan</th>
                                    <th>Harga Satuan</th>
									<th>Jumlah Belanja</th>
                                    {{--<th>Aksi</th>--}}
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($belanja as $data)
                                    <tr>
                                        <th>{{ $i++ }}</th>
                                        <th>{{ $data->number_belanja }}</th>
                                        <th>{{ $data->name_belanja }}</th>
                                        <th>{{ $data->volume }}</th>
                                        <th>{{ $data->unit }}</th>
                                        <th>{{ number_format($data->unit_price,2,',','.') }}</th>
                                        <th>{{ number_format($data->total_price,2,',','.') }}</th>
                                        {{--<th>--}}
                                            {{--<a href="#" onclick="call_modal_edit('{{ $keg->id }}','{{ $data->id }}')" class="btn btn-warning">ubah</a>--}}
                                            {{--<button type="submit" class="btn btn-danger" onclick="delete_belanjas('{{ $data->id }}')">hapus</button>--}}

                                        {{--</th>--}}
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

    <!-- Modal Tambah TBK -->
    <div class="modal fade" id="modal-belanja_tambah" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tambah Belanja DPA</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Kode Rekening</label>
                            <div class="col-sm-12">
                                <input type="text" name="number_belanja" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Uraian</label>
                            <div class="col-sm-12">
                                <textarea name="name_belanja" class="form-control"></textarea>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Volume</label>
                            <div class="col-sm-12">
                                <input type="text" name="volume" class="form-control">
                            </div>
                        </div>
						<div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="unit" class="form-control">
                            </div>
                        </div>
						<div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="unit_price" class="form-control">
                            </div>
                        </div>
                        
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_tambah_belanja">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->
	
	<!--modal edit belanja--->
	<div class="modal fade" id="modal-belanja_ubah">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Ubah Data Belanja</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Kode Rekening</label>
                            <div class="col-sm-12">
                                <input type="text" name="number_belanja1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Uraian</label>
                            <div class="col-sm-12">
                                <textarea name="name_belanja1" class="form-control"></textarea>
                            </div>
                        </div>
                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Volume</label>
                            <div class="col-sm-12">
                                <input type="text" name="volume1" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="unit1" class="form-control">
                            </div>
                        </div>
						 <div class="form-group">
                            <label for="inputEmail3" class="col-sm-3 control-label">Harga Satuan</label>
                            <div class="col-sm-12">
                                <input type="text" name="unit_price1" class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_ubah_belanja">Simpan</button>
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
                var id_keg;
                var id_goods;

               call_modal_insert = function(keg_id){
                   id_keg=keg_id;
                   $('#modal-belanja_tambah').modal('show');
               }

               $('#tombol_tambah_belanja').click(function (e) {
                   e.preventDefault();

                   $.ajax({
                       url: "{{ url('belanja') }}/"+id_keg+'/list',
                       type: "post",
                       data: {
                           '_method': 'put',
                           '_token': '{{ csrf_token() }}',
						   
                           'number_belanja' : $('[name="number_belanja"]').val(),
                           'name_belanja': $('[name="name_belanja"]').val(),
                           'volume' : $('[name="volume"]').val(),
						   'unit': $('[name="unit"]').val(),
                           'unit_price':$('[name="unit_price"]').val(),
                           //'total_price':$('[name="total_price"]').val(),
                           //'keg_id': $('[name="keg_id"]').val(),
                           
                       },
                       success: function(feetback){
                           $('#modal-belanja_tambah').modal('hide');
                           alert(feetback.info);
                           window.location.reload();
                       },
                       error : function () {
                           alert('Barang gagal disimpan');
                       }
                   })

               })

               call_modal_edit = function(keg_id, goods_id){
                   id_keg=keg_id;
                   id_goods = goods_id;
                   //var tanggal_faktur='';
                   //var date='';
                    $.ajax({
                        url: "{{ url('belanja') }}/"+keg_id+'/'+goods_id+'/list',
                        dataType: "json",
                        success: function (data) {
                            //date = new Date(data.dataForm.dateOfpurchase);
                             // var yer = data.dataForm.dateOfpurchase
                            //$('[name="dateOfpurchase1"]').val(date.getDate()+'-'+parseInt(date.getMonth()+1)+'-'+yer.split("-")[0]);
                            //$('[name="warehouse_id1"]').val(""+data.dataForm.warehouse_id).trigger('change');
                            //$('[name="suppliers_id1"]').val(""+data.dataForm.suppliers_id).trigger('change');
                            
							$('[name="number_belanja1"]').val(data.dataForm.number_belanja);
                            $('[name="name_belanja1"]').val(data.dataForm.name_belanja);
                            $('[name="volume1"]').val(data.dataForm.volume);
                            $('[name="unit1"]').val(data.dataForm.unit);
							$('[name="unit_price1"]').val(data.dataForm.unit_price);
							
                            $('#modal-belanja_ubah').modal('show');
                        },
                        error : function () {
                            alert("Gagal mengambil data barang");
                        }
                    })
               }

               $('#tombol_ubah_belanja').click(function (e) {
                   $.ajax({
                       url:"{{ url('belanja') }}/"+id_goods+"/update",
                       type: "post",
                       data :{
                           '_method': 'put',
                           '_token': '{{ csrf_token() }}',
                           'number_belanja' : $('[name="number_belanja1"]').val(),
                           'name_belanja': $('[name="name_belanja1"]').val(),
                           'volume' : $('[name="volume1"]').val(),
                           'unit':$('[name="unit1"]').val(),
                           'unit_price': $('[name="unit_price1"]').val(),
                       },
                       success : function(data){
                           alert('Data belanja berhasil di ubah');
                           console.log(data);
                           window.location.reload();
                       },
                       error: function () {
                           alert('Data tidak bisa diubah');
                       }
                   });
               })

               delete_belanjas = function(id){
                   if(confirm('Apa anda akan menghapus data ini ... ?') == true){
                       $.ajax({
                           url:"{{ url('belanja') }}/"+id+"/delete",
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
