
@extends('master_p_inspektorat_pemkab')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Dashboard
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    @if(empty($tahun_pengeluaran))
                    <div class="alert alert-danger alert-dismissible">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                        <h4><i class="icon fa fa-info"></i> Peringantan</h4>
                        Mohon Pengaturan Awal Di isi ...
                    </div>
                    @endif
                </div>
                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-aqua"><i class="fa fa-archive"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Jumlah Barang  <br>Gudang</span>
                            <span class="info-box-number">{{ $jumlah_barang }}<small></small></span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-green"><i class="fa fa-cart-arrow-down"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Penerimaan</span>
                            <span class="info-box-number">{{ number_format($total_penerimaan,2,',','.') }}</span>
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-md-3 col-sm-6 col-xs-12">
                    <div class="info-box">
                        <span class="info-box-icon bg-yellow"><i class="fa fa-truck"></i></span>

                        <div class="info-box-content">
                            <span class="info-box-text">Total Pengeluaran</span>
                            @if(!empty($total_pengeluaran[0]->hasil_total_pengeluaran))
                            <span class="info-box-number">{{ number_format($total_pengeluaran[0]->hasil_total_pengeluaran,2,',','.') }}</span>
                            @endif
                        </div>
                        <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>

                <div class="col-xs-12">
                    <div class="box box-info">
                        <div class="box-header">
                            <h3 class="box-title">Daftar Stok Barang</h3>
                        </div>
                        <!-- /.box-header -->
                        <div class="box-body">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Barang Dan Spec</th>
                                    <th>Stok Barang</th>
                                </tr>
                                </thead>
                                <tbody>
                                @if(!empty($daftar_stok))
                                @foreach($daftar_stok as $value)
                                    <tr>
                                        <td>{{ $value[0] }}</td>
                                        <td>{{ $value[1] }}</td>
                                        <td>{{ $value[2] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                                @endif
                            </table>
                        </div>
                        <!-- /.box-body -->
                    </div>
                </div>



            </div>

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop