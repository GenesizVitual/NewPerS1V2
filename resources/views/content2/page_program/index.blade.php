
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1 style="width: 100%">
                    Halaman Program
                </h1>
            </section>
            {{--<button type="button" class="btn bg-maroon btn-flat margin" data-toggle="modal" data-target="#modal-tambah-program">Tambah Program</button>--}}
            <button type="button" class="btn bg-primary btn-flat margin" onclick="singkronDPA()">Sinkron DPA</button>
            <a href="{{ url('data-simda') }}"  class="btn btn-warning btn-flat margin" >Lihat Data Simda</a>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">
                @if(!empty(Session::get('import_status')))
                    <div class="col-md-12">
                        <div class="callout callout-success">
                            <h4>Import Data Simda Telah Selesai</h4>

                            <p>Cek terlebih dahulu sebelum memulai menginput data</p>
                        </div>
                    </div>
                @endif
                @if(!empty($listProgram))
                    @foreach($listProgram as $program)
                    <div class="col-md-12">
                        <div class="box box-warning">
                            <div class="box-header with-border">
                                <h2 class="box-title"><font color="#FF000">Kode Rekening :</font>&nbsp; {{ $program['account_code'] }}</h2> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								
								<h3 class="box-title"><font color="#FF000">Nama Program :</font> {{ $program['program_name'] }}</h3>
								 
								 <div class="box-tools pull-right">
									<button type="button" class="btn btn-primary" title="Nilai Total" >
                                        @if(!empty($program->getKeg))
                                            @php($total_belanja=0)
                                            @foreach($program->getKeg as $get_belanja)
                                                @php($total_belanja+=$get_belanja->getSumBelanja->sum('total_price'))
                                            @endforeach
                                            {{ number_format($total_belanja,2,',','.') }}
                                        @endif
                                    </button>
									{{--<button type="button" class="btn btn-box-tool" title="Mengubah Program" ><i class="fa fa-fw fa-pencil" onclick="get_data_no_program('{{ $program->id }}')"></i>--}}
                                    {{--</button>--}}
                                    {{--<button type="button" class="btn btn-box-tool" title="Menghapus Program" ><i class="fa fa-fw fa-eraser" onclick="delete_program('{{ $program->id }}')"></i>--}}
                                    {{--</button>--}}
								</div>
                                <!-- /.box-tools -->
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body" style="">
                                <div class="col-md-12">
								
                                     <a href="#" onclick="create_keg('{{ $program->id }}')">Buat Kegiatan Anda</a>
                                </div>
                                 @if(!empty($program->getKeg))
                                        @foreach($program->getKeg as $keg)
                                        <div class="col-md-12">
                                            <li> {{ $keg->number_keg }} &nbsp;&nbsp;&nbsp; {{ $keg->keg_name }}
											
                                                {{--<a href="#" class="pull-right" onclick="hapus_keg('{{ $keg->id }}')" style="padding-left: 5px">Hapus</a>--}}
                                                {{--<a href="#" onclick="get_data_keg('{{ $keg->id }}')" class="pull-right" style="padding-left: 5px">Ubah</a>--}}

												<a href="{{ url('belanja/'.$keg->id.'/list') }}" class="pull-right">Belanja</a>
												<a href="#" class="pull-right" style="padding-right: 20px; color: red;"> @if(!empty($keg->getSumBelanja->sum('total_price')) ) Rp {{ number_format($keg->getSumBelanja->sum('total_price'),2,'.','.') }} @endif</a>
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
                            <p>Silakan buat Program terlebih dahulu</p>
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
    <div class="modal fade" id="modal-tambah-program" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Program</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Kode Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Kode Rekening" name="accountPROG">
                            </div>
                        </div>
                    </div>
					<div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Program</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Nama Rekening" name="namePROG">
								<input type="hidden" class="form-control" value="{{ ($dpa->id) }}" name="dpa_id">
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Tahun Anggaran</label>
                            <div class="col-sm-10">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="fiscal_years_id1">
                                    <option>Pilih Tahun Anggaran</option>
                                    @if(!empty($tahun_anggaran))
                                        @foreach($tahun_anggaran as $bid)
                                            <option value="{{ $bid->id }}">{{ $bid->years }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_simpan_program">Simpan</button>
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
	<!--ubah program--->
	 <div class="modal fade" id="modal-ubah-program" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Program</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Kode Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Kode Rekening"  name="numberPROGRAM2">
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Program</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Nama Program"  name="namePROGRAM2">
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Tahun Anggaran</label>
                            <div class="col-sm-10">
                                <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="fiscal_years_id2">
                                    <option>Pilih Tahun Anggaran</option>
                                    @if(!empty($tahun_anggaran))
                                        @foreach($tahun_anggaran as $bid)
                                            <option value="{{ $bid->id }}">{{ $bid->years }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="ubah_program">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>



    <!-- Modal Tambah Kegiatan -->
    <div class="modal fade" id="modal-tambah-keg" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kegiatan</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Kode Kegiatan :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Kode Rekening" name="numberKeg1">
                            </div>
                        </div>
					</div>
					<div class="box-body">
						<div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Kegiatan :</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Nama Rekening" name="nameKeg1">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_simpan_keg">Simpan</button>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.modal -->

    <!-- Modal ubah keg-->
    <div class="modal fade" id="modal-ubah-keg" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Kegiatan</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Kode Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Kode Rekening" name="numberKeg2">
                            </div>
                        </div>
                    </div>
                </div>
				<div class="modal-body">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Nama Rekening</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="Masukan Nama Rekening" name="nameKeg2">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="button" class="btn btn-primary" id="tombol_ubah_keg">Simpan</button>
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
			  var id_program;
				var id_keg;
            // Perintah crud Program===========================
            $('#tombol_simpan_program').click(function (e) {
                e.preventDefault();
                $.ajax({
                    url     : "{{ url('program/create') }}",
                    type    : "post",
                    data    : {
                        'accountPROG' : $('[name="accountPROG"]').val(),
						'namePROG' : $('[name="namePROG"]').val(),
						'dpa_id' : $('[name="dpa_id"]').val(),
						'fiscal_years_id' : $('[name="fiscal_years_id1"]').val(),
                        '_token' : "{{csrf_token()}}"
                    },
                    success: function (data) {
                        $('#modal-tambah-program').modal("hide");
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                            }
                        });
                        window.location.reload();
                    }, error: function () {
                        alert("Data Tidak Boleh kosong");
                    }
                });

            })


           get_data_no_program=function(program_id){
                var url = "{{ url('program') }}/"+program_id+"/edit";
                $.ajax({
                    url         : url,
                    dataType    : "Json",
                    success: function (data) {
                        console.log(data);
                         $('[name="numberPROGRAM2"]').val(data.program.account_code);
						 $('[name="namePROGRAM2"]').val(""+data.program.program_name);
						 $('[name="fiscal_years_id2"]').val(data.program.fiscal_years_id).trigger('change');
                         $('#modal-ubah-program').modal("show");
                         id_program = program_id;
                    }
                })
            }

            $('#ubah_program').click(function (e) {
                e.preventDefault();

                $.ajax({
                  url       : "{{ url('program') }}/"+id_program+"/edit",
                  type      :"post",
                  data      :{
                      '_method': 'put',
                      'numberPROGRAM' : $('[name="numberPROGRAM2"]').val(),
					  'namePROGRAM' : $('[name="namePROGRAM2"]').val(),
                      'fiscal_years_id' : $('[name="fiscal_years_id"]').val(),
                      '_token' : "{{csrf_token()}}"
                  },
                  success: function (data) {
                        alert("Data Program Telah diubah");
                        $('#modal-ubah-program').modal("hide");
                        window.location.reload();
                  },
                  error: function () {
                      alert("Ada yang Salah");
                  }
                })
            })

            delete_program = function (id_program) {
                if(confirm("Peringatan Kegiatan yang berkaitan dengan Program ini akan Hilang ...!!")== true){
                    $.ajax({
                        url: "{{ url('program') }}/"+id_program+"/destroy",
                        method: "post",
                        data: {
                            "_method" : "PUT",
                            "_token" : "{{ csrf_token() }}"
                        },
                        success : function (data) {
                            alert("Program ini telah dihapus"+ data.no_program);
                            window.location.reload();
                        },error: function(){
                            alert("Gagal Menghapus data ini");
                        }
                    })
                }else{
                    alert("Perintah Hapus Dibatalkan");
                }
            }

            // add keg=============================================

            create_keg = function (program_id) {
                id_program=program_id;
                $('#modal-tambah-keg').modal('show');
            }

            $('#tombol_simpan_keg').click(function(e){
                e.preventDefault();
                $.ajax({
                      url: "{{ url('keg') }}/"+id_program+"/create",
                      type: "post",
                      data : {
                          '_method' : 'put',
                          '_token'  : '{{ csrf_token() }}',
                          'numberKeg' : $('[name="numberKeg1"]').val(),
						  'nameKeg' : $('[name="nameKeg1"]').val()
                      },
                      success: function(data){
                          alert("Kegiatan Baru saja ditambahkan dengan no : "+ data.number_keg);
                          $('#modal-tambah-keg').modal('hide');
                          window.location.reload();
                      },
                      error: function () {
                          alert("Kegiatan gagal dibuat");
                      }
                })
            })

           get_data_keg = function (keg_id){
                $.ajax({
                    url: "{{ url('keg') }}/"+keg_id,
                    dataType : "json",
                    success: function (data) {
                        id_keg = keg_id;
                        console.log(data);
                        $('[name="numberKeg2"]').val(data.number_keg);
						 $('[name="nameKeg2"]').val(data.keg_name);
                        $('#modal-ubah-keg').modal('show');
                    },
                    error: function(){
                        alert('Data tidak dapat di ubah');
                    }
                })
            }

            $('#tombol_ubah_keg').click(function (e) {
                e.preventDefault();

                $.ajax({
                   url: "{{ url('keg') }}/"+id_keg,
                   type: 'post',
                   data : {
                       '_method': 'put',
                       '_token' : '{{ csrf_token() }}',
                       'numberKeg': $('[name="numberKeg2"]').val(),
					    'nameKeg': $('[name="nameKeg2"]').val()
                   } ,
                   success: function (data) {
                       alert('No TBk telah diubah');
                       $('#modal-ubah-keg').modal('hide');
                       window.location.reload();
                   },
                    error: function () {
                        alert("No TBK gagal diubah");
                    }
                });
            });


            hapus_keg = function(keg_id)
            {
                if(confirm('Mengapus Kegiatan ini akan menghilangkan data Belanja pada kegiatan yang bersangkutan')== true){
                    $.ajax({
                        url: "{{ url('keg') }}/delete/"+keg_id,
                        method: "post",
                        data: {
                            '_method':'put',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data){
                            alert('Kegiatan telah dihapus');
                            window.location.reload();
                        }
                    })
                }else{
                    alert("Perintah Hapus dibatalkan");
                }
            }

            singkronDPA = function (){
                if(confirm('Pastikan tidak ada tahun anggaran yang aktif lebih dari satu tahun anggaran, jika ingin melakukan sinkronsasi jumlah DPA berdasarkan program,kegiatan, belanja ..!')){
                    $.ajax({
                       url:'{{ url('singkron_dpa') }}',
                       type: 'post',
                       data: {
                           '_token': '{{ csrf_token() }}'
                       },
                       success: function(feetback){
                          alert(feetback.info);
                       },
                       error : function(){
                          alert('Gagal mensinkronkan data belanja');
                       }
                    });
                }else{
                    alert('Proses Sinkron data telah dibatalkan');
                }
            }
            
        });

    </script>

@stop