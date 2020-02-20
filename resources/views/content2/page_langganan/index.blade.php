
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Langganan Hosting Web
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->

                <div class="col-md-12">
                    <!-- Custom Tabs -->
                    <div class="nav-tabs-custom">
                        <ul class="nav nav-tabs">
                            <li class="active"><a href="#tab_1" data-toggle="tab">Unpaid</a></li>
                            <li><a href="#tab_2" data-toggle="tab">Paid</a></li>
                            <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab_1">
                                <div class="table-responsive">
                                    @if(count($status_pembayaran)>0)
                                        <a href="#" data-toggle="tooltip" onclick="alert('Anda tidak bisa membuat tagihan, karena masa aktif account anda belum berakhir')" class="mb-xs mt-xs mr-xs btn btn-primary"> Masa aktif anda belum berakhir </a>
                                    @else
                                        <a href="{{ url('langganan') }}" data-toggle="tooltip" class="mb-xs mt-xs mr-xs btn btn-primary"> Buat Tagihan </a>
                                    @endif

                                    <table class="table mb-none">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Periode</th>
                                            <th>Harga</th>
                                            <th>Keterangan</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Berakhir</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($index=1)
                                        @foreach($data as $datas)
                                            <tr>
                                                <td>{{ $index++ }}</td>
                                                <td>{{ $datas->get_periode->priode }}</td>
                                                <td>{{ number_format($datas->get_harga->range,2,'.','.') }}</td>
                                                <td>{{ $datas->get_harga->keterangan }}</td>
                                                <td>{{ date('d-m-Y', strtotime($datas->begin_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($datas->end_date)) }}</td>
                                                <td>{{ number_format($datas->get_periode->value* $datas->get_harga->range ,2,'.','.') }}</td>
                                                <td>
                                                    @if($datas->status=='0')
                                                       Gratis Masih Masa Trial 30 hari
                                                    @elseif($datas->status=='2')
                                                        Sedang diproses
                                                        @elseif($datas->status_aktif=='1')
                                                            Masih Berjalan
                                                        @elseif($datas->status_aktif=='0')
                                                            Masa aktif anda telah berakhir
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($datas->status=='0')
                                                        Gratis Masa Trial 30 Hari
                                                    @else
                                                        <a href="{{ url('detailtagihan/'.$datas->id) }}" class="btn btn-warning">Lihat</a>
                                                        <a href="{{ url('konfirmasi/'.$datas->id) }}" class="btn btn-primary">Konfirmasi</a>

                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                            <div class="tab-pane" id="tab_2">
                                <div class="table-responsive">
                                    <table class="table mb-none">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Periode</th>
                                            <th>Harga</th>
                                            <th>Keterangan</th>
                                            <th>Tanggal Mulai</th>
                                            <th>Tanggal Berakhir</th>
                                            <th>Total</th>
                                            <th></th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @php($index2=1)
                                        @foreach($data_paid as $datas)
                                            <tr>
                                                <td>{{ $index2++ }}</td>
                                                <td>{{ $datas->get_periode->priode }}</td>
                                                <td>{{ number_format($datas->get_harga->range,2,'.','.') }}</td>
                                                <td>{{ $datas->get_harga->keterangan }}</td>
                                                <td>{{ date('d-m-Y', strtotime($datas->begin_date)) }}</td>
                                                <td>{{ date('d-m-Y', strtotime($datas->end_date)) }}</td>
                                                <td>{{ number_format($datas->get_periode->value* $datas->get_harga->range ,2,'.','.') }}</td>
                                                <td>
                                                    @if($datas->status=='3')
                                                        Sudah dibayar
                                                    @endif
                                                </td>
                                                <td>

                                                </td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <!-- /.tab-pane -->

                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div>
                    <!-- nav-tabs-custom -->
                </div>
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop