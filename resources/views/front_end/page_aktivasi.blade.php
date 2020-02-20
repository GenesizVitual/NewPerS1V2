<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <title>Halaman Aktivasi</title>
</head>
<body >
<div class="row">
   <div class="col-md-12" align="center" style="margin-top: 10%">
       @if($data->status_aktiv==0)
           <h1>Silahkan aktifasi Persediaan.id Anda ...?? </h1>
           <h3>{{ $data->instance }}</h3>
           <form action="{{ url('cek-aktivasi') }}" method="post">
               <input class="form-control" style="width: 50%" type="Masukan Kode Aktifasi Anda Disini" name="serial_key" placeholder="example : 534-GU-030-2019" required/>
               <button class="btn btn-primary" type="submit" style="margin-top: 1%; width: 20%">Proses</button>
                {{ csrf_field() }}
               <br>
               @if(!empty(@Session::get('message_aktivasi')))
                    <span style="color:red">{{ @Session::get('message_aktivasi') }}</span>
               @endif
           </form>
       @else
           <div class="alert alert-info alert-dismissible">
               <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
               <h4><i class="icon fa fa-info"></i> Infomasi</h4>
               Masa aktif belum berakhir, anda tidak bisa melakukan perpanjangan selama status anda masih aktif
           </div>
       @endif
   </div>
</div>
</body>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

</html>