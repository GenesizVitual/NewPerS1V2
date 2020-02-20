
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-2" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman SPJ
                </h1>
            </section>
            <button type="button" class="btn bg-maroon btn-flat margin" data-toggle="modal" data-target="#modal-tambah-spj">Membuat SPJ</button>

        </div>
        <div class="col-md-3" style="padding-bottom: 1%; padding-top: 1%">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    @if(!empty($dpa->pagu_value))
                    <h2 >Rp {{ number_format($dpa->pagu_value,2,'.','.') }}</h2>
                    @else
                        <h2 >Rp {{ number_format(0,2,'.','.') }}</h2>
                    @endif
                    <p>DPA</p>
                </div>
            </div>

        </div>
        <div class="col-md-3" style="padding-bottom: 1%; padding-top: 1%">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h2 id="sisa_dpa">Rp {{ number_format($jumlah_spj,2,'.','.') }}</h2>
                    <p>Total SPJ</p>
                </div>
            </div>

        </div>
        <div class="col-md-3" style="padding-bottom: 1%; padding-top: 1%">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    @if(!empty($dpa->pagu_value))
                    <h2 id="sisa_dpa">Rp {{ number_format($dpa->pagu_value-$jumlah_spj,2,'.','.') }}</h2>
                    @else
                        <h2 id="sisa_dpa">Rp {{ number_format(0,2,'.','.') }}</h2>
                    @endif
                    <p>Sisa DPA</p>
                </div>

            </div>

        </div>


        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">
                @if(!empty($listSpj))
                    @foreach($listSpj as $spj)
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h3 class="box-title">No SPJ: {{ $spj->number_spj }}</h3>

                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-primary" title="Nilai Total" >
                                       @foreach($totals_spj as $bd)
                                           @if($spj->id==$bd->spj_id)
                                                {{ number_format($bd->totalSJP,2,'.','.') }}
                                            @endif
                                        @endforeach
                                    </button>
                                    <button type="button" class="btn btn-box-tool" title="Mengubah SPJ" ><i class="fa fa-fw fa-pencil" onclick="get_data_no_spj('{{ $spj->id }}')"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" title="Menghapus SPJ" ><i class="fa fa-fw fa-eraser" onclick="delete_spj('{{ $spj->id }}')"></i>
                                    </button>
                                </div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="">
                                <div class="col-md-12">
                                     <a href="#" onclick="create_tbk('{{ $spj->id }}')">Buat TBK Anda</a>
                                </div>
                                    @if(!empty($spj->getTbk))
                                        @foreach($spj->getTbk as $test)
                                        <div class="col-md-12">
                                            <li> {{ $test->number_tbk }}
                                                <a href="#" class="pull-right" onclick="hapus_tbk('{{ $test->id }}')" style="padding-left: 5px">Hapus</a>
                                                <a href="#" onclick="get_data_tbk('{{ $test->id }}')" class="pull-right" style="padding-left: 5px">Ubah</a>
                                                <a href="{{ url('goodreceipt/'.$test->id.'/list') }}" class="pull-right">Penerimaan</a>
                                                <a href="#" class="pull-right" style="padding-right: 20px; color: red;"> @if(!empty($test->getSumReciept->sum('totalPrice')) ) Rp {{ number_format($test->getSumReciept->sum('totalPrice'),2,'.','.') }} @endif</a>
                                            </li>
                                        </div>
                                         @endforeach
                                    @endif

                            </div>
                            <!-- /.box-body -->
                        </div>
                        <!-- /.box -->
                    </div>
                    @endforeach
                @else
                    <div class="col-md-12">
                        <div class="callout callout-warning">
                            <h4>Informasi</h4>
                            <p>Silakan buat SPJ terlebih dahulu</p>
                        </div>
                    </div>
                @endif
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->



    <!-- Modal Tambah Spj -->
    <div class="modal fade" id="modal-tambah-spj" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Surat Pertanggung Jawaban</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">No: SPJ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan No Spj" name="numberSPJ">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_simpan_spj">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!--- Akhir Modal Tambah Spj --->

    <!-- Modal ubah Spj -->
    <div class="modal fade" id="modal-ubah-spj" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Surat Pertanggung Jawaban</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">No: SPJ</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan No Spj"  name="numberSPJ2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="ubah_spj">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!--- Akhir Modal Ubah Spj --->



    <!-- Modal Tambah TBK -->
    <div class="modal fade" id="modal-tambah-tbk" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tanda Bukti Kas (TBK)</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">No TBK :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan No TBK" name="numberTbk1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_simpan_tbk">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal Tambah TBK -->
    <div class="modal fade" id="modal-ubah-tbk" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Tanda Bukti Kas (TBK)</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group" style="padding-bottom: 5%">
                            <label for="inputEmail3" class="col-sm-2 control-label">No SPJ :</label>
                            <div class="col-sm-10">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="id_spj">
                                    <option>Daftar SPJ</option>
                                    @foreach($listSpj as $data)
                                        <option  value="{{ $data->id }}">{{ $data->number_spj }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                         <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">No TBK :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan No TBK" name="numberTbk2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_ubah_tbk">Simpan</button>
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

            var id_spj;
            var id_tbk;
            // Perintah crud SPJ===========================
            $('#tombol_simpan_spj').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url     : "{{ url('goodsreceipt/create') }}",
                    type    : "post",
                    data    : {
                        'numberSPJ' : $('[name="numberSPJ"]').val(),
                        '_token' : "{{csrf_token()}}"
                    },
                    success: function (data) {
                        $('#modal-tambah-spj').modal("hide");
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        window.location.reload();
                    }, error: function () {
                        alert("No Spj Tidak Bileh kosong");
                    }
                });

            })



           get_data_no_spj=function(spj_id){
                var url = "{{ url('goodsreceipt') }}/"+spj_id+"/edit";
                $.ajax({
                    url         : url,
                    dataType    : "Json",
                    success: function (data) {
                        $('[name="numberSPJ2"]').val(data.spj.number_spj);
                        $('#modal-ubah-spj').modal("show");
                        id_spj = spj_id;
                    }
                })
            }

            $('#ubah_spj').click(function (e) {
                e.preventDefault();

                $.ajax({
                  url       : "{{ url('goodsreceipt') }}/"+id_spj+"/edit",
                  type      :"post",
                  data      :{
                      '_method': 'put',
                      'numberSPJ' : $('[name="numberSPJ2"]').val(),
                      '_token' : "{{csrf_token()}}"
                  },
                  success: function (data) {
                        alert("No Spj Telah diubah");
                        $('#modal-ubah-spj').modal("hide");
                        window.location.reload();
                  },
                  error: function () {
                      alert("Ada yang Salah");
                  }
                })
            })

            delete_spj = function (id_spj) {
                if(confirm("Peringatan TBK yang berkaitan dengan SPJ ini akan Hilang ...!!")== true){
                    $.ajax({
                        url: "{{ url('goodsreceipt') }}/"+id_spj+"/destroy",
                        method: "post",
                        data: {
                            "_method" : "PUT",
                            "_token" : "{{ csrf_token() }}"
                        },
                        success : function (data) {
                            alert("SPJ ini telah dihapus"+ data.no_spj);
                            window.location.reload();
                        },error: function(){
                            alert("Gagal Menghapus data ini");
                        }
                    })
                }else{
                    alert("Perintah Hapus Dibatalkan");
                }
            }

            //=============================================

            create_tbk = function (spj_id) {
                id_spj=spj_id;
                $('#modal-tambah-tbk').modal('show');
            }

            $('#tombol_simpan_tbk').click(function(e){
                e.preventDefault();
                $.ajax({
                      url: "{{ url('tbk') }}/"+id_spj+"/create",
                      type: "post",
                      data : {
                          '_method' : 'put',
                          '_token'  : '{{ csrf_token() }}',
                          'numberTbk' : $('[name="numberTbk1"]').val()
                      },
                      success: function(data){
                          alert("Tbk Baru saja ditambahkan dengan no : "+ data.number_tbk);
                          $('#modal-tambah-tbk').modal('hide');
                          window.location.reload();
                      },
                      error: function () {
                          alert("TBK gagal dibuat");
                      }
                })
            })

            get_data_tbk = function (tbk_id){
                $.ajax({
                    url: "{{ url('tbk') }}/"+tbk_id,
                    dataType : "json",
                    success: function (data) {
                        id_tbk = tbk_id;
                        console.log(data);
                        $('[name="numberTbk2"]').val(data.number_tbk);
                        $('[name="id_spj"]').val(data.spj_id).trigger('change');
                        $('#modal-ubah-tbk').modal('show');
                    },
                    error: function(){
                        alert('Data tidak dapat di ubah');
                    }
                })
            }

            $('#tombol_ubah_tbk').click(function (e) {
                e.preventDefault();

                $.ajax({
                   url: "{{ url('tbk') }}/"+id_tbk,
                   type: 'post',
                   data : {
                       '_method': 'put',
                       '_token' : '{{ csrf_token() }}',
                       'numberTbk': $('[name="numberTbk2"]').val(),
                       'spj_id':  $('[name="id_spj"]').val()
                   } ,
                   success: function (data) {
                       alert('No TBk telah diubah');
                       $('#modal-ubah-tbk').modal('hide');
                       window.location.reload();
                   },
                    error: function () {
                        alert("No TBK gagal diubah");
                    }
                });
            });

            hapus_tbk = function(tbk_id)
            {
                if(confirm('Mengapus TBK ini akan menghilangkan data penerimaan pada tbk yang bersangkutan')== true){
                    $.ajax({
                        url: "{{ url('tbk') }}/delete/"+tbk_id,
                        method: "post",
                        data: {
                            '_method':'put',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data){
                            alert('TBK telah dihapus');
                            window.location.reload();
                        }
                    })
                }else{
                    alert("Peritah Hapus dibatalkan");
                }
            }

        });

    </script>

@stop