
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">

            <!-- Custom Tabs (Pulled to the right) -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs pull-right">
                    <li class="active"><a href="#tab_1-1" data-toggle="tab">Belum Berlangganan</a></li>
                    <li><a href="#tab_2-2" data-toggle="tab">Sudah Berlangganan</a></li>
                    <li><a href="#tab_3-2" data-toggle="tab">Sudah Konfirmasi Pembayaran</a></li>
                    <li><a href="#tab_4-2" data-toggle="tab">Langganan Masih Aktif</a></li>
                    <li class="pull-left header"><i class="fa fa-th"></i>Info Langganan Pengguna</li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1-1">
                        <div class="table-responsive" style="padding-top: 1%">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Periode</th>
                                    <th>Harga Paket</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($belum_bayar as $data)
                                    @if(!empty($data))
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $data->get_user->name }}</th>
                                            <th>{{ $data->get_periode->priode }}</th>
                                            <th>{{ number_format($data->get_harga->range,2,'.',',') }}</th>
                                            <th>{{ $data->begin_date }}</th>
                                            <th>{{ $data->end_date }}</th>
                                            <th><a href="{{ url('pesan/'.$data->user_id) }}">Pesan</a> </th>
                                        </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2-2">
                        <div class="table-responsive" style="padding-top: 1%">
                            <table id="example_table_sudah_langganan" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Periode</th>
                                    <th>Harga Paket</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i2=1)
                                @foreach($sudah_langganan as $data1)
                                    <tr>
                                        <th>{{ $i2++ }}</th>
                                        <th>{{ $data1->get_user->name }}</th>
                                        <th>{{ $data1->get_periode->priode }}</th>
                                        <th>{{ number_format($data1->get_harga->range,2,'.',',') }}</th>
                                        <th>{{ $data1->begin_date }}</th>
                                        <th>{{ $data1->end_date }}</th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3-2">
                        <div class="table-responsive" style="padding-top: 1%">
                            <table id="example_table_sudah_konfirmasi" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Periode</th>
                                    <th>Harga Paket</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Lihat</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i3=1)
                                @foreach($sudah_konfimrasi as $data3)
                                    <tr>
                                        <th>{{ $i3++ }}</th>
                                        <th>{{ $data3->get_user->name }}</th>
                                        <th>{{ $data3->get_periode->priode }}</th>
                                        <th>{{ number_format($data3->get_harga->range,2,'.',',') }}</th>
                                        <th>{{ $data3->begin_date }}</th>
                                        <th>{{ $data3->end_date }}</th>
                                        <th>
                                            <button class="btn btn-primary" onclick="aktifkan_langganan({{ $data3->id }})">Aktifkan</button>
                                            <button class="btn btn-warning" onclick="lihat_struk({{ $data3->id }})">Lihat</button>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane" id="tab_4-2">
                        <div class="table-responsive" style="padding-top: 1%">
                            <table id="example_table_masih_aktif" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Pengguna</th>
                                    <th>Periode</th>
                                    <th>Harga Paket</th>
                                    <th>Tanggal Mulai</th>
                                    <th>Tanggal Berakhir</th>
                                    <th>Lihat</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i4=1)
                                @foreach($sudah_aktif_accountnya as $data4)
                                    <tr>
                                        <th>{{ $i4++ }}</th>
                                        <th>{{ $data4->get_user->name }}</th>
                                        <th>{{ $data4->get_periode->priode }}</th>
                                        <th>{{ number_format($data4->get_harga->range,2,'.',',') }}</th>
                                        <th>{{ $data4->begin_date }}</th>
                                        <th>{{ $data4->end_date }}</th>
                                        <th>
                                            <button class="btn btn-primary" onclick="off_langganan({{ $data4->id }})">Expired</button>
                                            <button class="btn btn-warning" onclick="lihat_struk({{ $data4->id }})">Lihat</button>
                                        </th>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->

        <!-- Main content -->
        <section class="content">

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Modal ubah TBK -->
    <div class="modal fade" id="modal-struk" >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title">Bukti Struk Pembayaran</h4>
                </div>
                <div class="modal-body">
                    <div class="box-body">
                        <div class="form-group" id="gambar_struck">
                            <img src="https://banner2.kisspng.com/20180409/hbq/kisspng-anime-naruto-uzumaki-sasuke-uchiha-touken-ranbu-ma-manga-boy-5acbd73d281c62.8516867015233083491643.jpg" style="width: 100%; height: 100%" id="gambar_struck"/>
                        </div>
                    </div>
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
            $('#example_table_sudah_langganan').DataTable();
            $('#example_table_sudah_konfirmasi').DataTable();
            $('#example_table_masih_aktif').DataTable();

            lihat_struk = function (id) {
               $.ajax({
                   url : "{{ url('lihat_struk') }}/"+ id,
                   dataType : "json",
                   success : function (data) {
                        console.log(data.confirm.nama_bukti_rekening)
                       var src = "{{ asset('file_rek') }}/"+ data.confirm.nama_bukti_rekening;
                        $('#gambar_struck').html("<img src='"+src+"' style='width: 100%; height: 100%'>")
                        $('#modal-struk').modal('show')
                   }
               })
            }

            aktifkan_langganan = function (id) {
                if(confirm("Apakah Anda Akan mengaktifkan langganan ini ...?")){
                    $.ajax({
                        url : "{{ url('lihat_struk') }}/"+ id,
                        type : "post",
                        data :{
                            '_method': 'put',
                            '_token': '{{ csrf_token() }}',
                        },
                        success : function (data) {
                            if(data.status=="true"){
                                alert(data.info);
                            }else {
                                alert(data.info)
                            }
                        }
                    })
                }else{
                    alert("Langganan ini tidak diperpanjang");
                }
            }

            off_langganan = function (id) {
                if(confirm("Apakah Anda Akan mengnonaktifkan langganan ini ...?")){
                    $.ajax({
                        url : "{{ url('off_langganan') }}/"+ id,
                        type : "post",
                        data :{
                            '_method': 'put',
                            '_token': '{{ csrf_token() }}',
                        },
                        success : function (data) {
                            if(data.status=="true"){
                                alert(data.info);
                            }else {
                                alert(data.info)
                            }
                        }
                    })
                }else{
                    alert("Langganan ini tidak diperpanjang");
                }
            }
        })
    </script>
@stop