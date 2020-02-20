<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Persediaan.id | Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/Ionicons/css/ionicons.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets2/dist/css/AdminLTE.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body onload="window.print();">
<div class="wrapper">
  <!-- Main content -->
  <section class="invoice" >
    <!-- title row -->
    <div class="row">
      <div class="col-xs-12">
        <h2 class="page-header">
          <i class="fa fa-globe"></i> CV.Sumber Info Media
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
          Jln. Pangeran Antasari<br>
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
          {{ $instansi->getDistrict->district }}, {{ $instansi->getProvince->province }}<br>
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
        </div>
      </div>
      <!-- /.col -->
    </div>
    <!-- /.row -->


  </section>
  <!-- /.content -->
</div>
<!-- ./wrapper -->
</body>
</html>
