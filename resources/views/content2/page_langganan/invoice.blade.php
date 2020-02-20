
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Invoice
                <small>#{{ $data->id }}</small>
            </h1>
            <ol class="breadcrumb">
                <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                <li><a href="#">Examples</a></li>
                <li class="active">Invoice</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="invoice" >
            <!-- title row -->
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="page-header">
                        <i class="fa fa-globe"></i> CV. Sumber Info Media
                        <small class="pull-right">{{ date('d M Y') }}</small>
                    </h2>
                </div>
                <!-- /.col -->
            </div>
            <!-- info row -->
            <div class="row invoice-info" id="printing">
                <div class="col-sm-4 invoice-col">
                    From
                    <address>
                        <strong>CV. Sumber Info Media</strong><br>
                        Jln. Pangeran Antasari Ruko No.3<br>
                        Kendari, Sulawesi Tenggara<br>
                        Phone: (0401) 3083-049 or 0852-2800-6675<br>
                        Email: info@persediaan.id
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    To
                    <address>
                        <strong>{{ $data->get_user->name }}</strong><br>
                        {{ $instansi->alamat }}<br>
                        {{ $instansi->getDistrict->district }}, {{ $instansi->getProvince->province }} <br>
                        Phone: {{ $instansi->no_telp }}<br>
                        Email: {{ $data->get_user->email }}
                    </address>
                </div>
                <!-- /.col -->
                <div class="col-sm-4 invoice-col">
                    <b>Invoice #{{ $data->id  }}</b><br>
                    <br>
                    <b>Tanggal Tagihan:</b> {{ date('d M Y') }}<br>
                    <b>Tanggal Jatuh Tempo:</b> {{ date('d M Y', strtotime($data->end_date)) }}
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- Table row -->
            <div class="row">
                <div class="col-xs-12 table-responsive">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>Qty</th>
                            <th>Deskripsi</th>
                            <th>Durasi</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                        </thead>
                        <tbody>

                        <tr>
                            <td>1</td>
                            <td>Biaya langganan sewa server hosting aplikasi Persediaan.id</td>
                            <td>{{ $data->get_periode->priode }}</td>
                            <td>{{ number_format($data->get_harga->range,2,',','.') }}</td>
                            <td>{{ number_format($data->get_periode->value * $data->get_harga->range,2,',','.') }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <div class="row">
                <!-- accepted payments column -->
                <div class="col-xs-6">
                    <p class="lead">Payment Methods:</p>
                    <p> Pembayaran dapat dilakukan melalui transfer ke rekening berikut: </p>
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                      1.BPD Sultra
                        <br>No. Rekening : 243.01.04.000006-2
                        <br> a/n CV. Sumber info media
                    </p>
                    <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
                      2.Bank Muamalat
                        <br>No. Rekening : 8280001189
                        <br> a/n Sumber info media,CV
                    </p>
                </div>
                <!-- /.col -->
                <div class="col-xs-6">
                    <p class="lead">Amount Due {{ date('d M Y', strtotime($data->end_date)) }}</p>

                    <div class="table-responsive">
                        <table class="table">
                            <tr>
                                <th style="width:50%">Subtotal:</th>
                                <td>{{ number_format($data->get_periode->value * $data->get_harga->range,2,'.','.') }}</td>
                            </tr>
                            <tr>
                                <th>Tax (10%)</th>
                                @php($tax = ($data->get_periode->value * $data->get_harga->range)*0.1);
                                <td>{{ number_format(($data->get_periode->value * $data->get_harga->range)*0.1,2,'.','.') }}</td>
                            </tr>
                            <tr>
                                <th>Total:</th>
                                <td>{{ number_format(($data->get_periode->value * $data->get_harga->range)+$tax,2,'.','.') }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <!-- /.col -->
            </div>
            <!-- /.row -->

            <!-- this row will not appear when printing -->
            <div class="row no-print">
                <div class="col-xs-12">
                    <a href="{{ url('detail_print/'.$data->id) }}" target="_blank" class="btn btn-default"><i class="fa fa-print"></i> Print</a>
                    <a href="{{ url('konfirmasi/'.$data->id) }}" class="btn btn-success pull-right"><i class="fa fa-credit-card"></i> Konfirmasi Pembayaran </a>
                </div>
            </div>
        </section>
        <!-- /.content -->
        <div class="clearfix"></div>
    </div>
    <!-- /.content-wrapper -->
@stop
