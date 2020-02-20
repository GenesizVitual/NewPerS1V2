<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="csrf-token" id="token" content="{{ csrf_token() }}">
  <title>Persediaan.id</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <link id="favicon" rel="shortcut icon" href="{{ asset('front_end/img/favicon.png') }}" type="image/png">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/font-awesome/css/font-awesome.min.css') }}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/Ionicons/css/ionicons.min.css') }}">

  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/select2/dist/css/select2.min.css') }}">

  <!-- DataTables -->
  <link rel="stylesheet" href="{{ asset('assets2/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('assets2/dist/css/AdminLTE.min.css') }}">

  <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{ asset('assets2/dist/css/skins/_all-skins.min.css') }}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

  <style>
    .example-modal .modal {
      position: relative;
      top: auto;
      bottom: auto;
      right: auto;
      left: auto;
      display: block;
      z-index: 1;
    }

    .example-modal .modal {
      background: transparent !important;
    }

    .custom_table {
      font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
      border-collapse: collapse;
      width: 100%;
    }

    .custom_table td, .custom_table th {
      border: 1px solid #ddd;
      padding: 8px;
    }

    .custom_table tr:nth-child(even){background-color: #f2f2f2;}

    .custom_table tr:hover {background-color: #ddd;}

    .custom_table th {
      padding-top: 12px;
      padding-bottom: 12px;
      text-align: left;
      background-color: #4CAF50;
      color: white;
    }


  </style>

  <style>
    .buttonload {
      background-color: #4CAF50; /* Green background */
      border: none; /* Remove borders */
      color: white; /* White text */
      padding: 12px 24px; /* Some padding */
      font-size: 16px; /* Set a font-size */
    }

  </style>
</head>
<body class="hold-transition skin-red sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

   @include('include2.header')
  <!-- =============================================== -->

  @include('include2.Lsidebar')
  <!-- =============================================== -->

     @yield('content')

  @include('include2.footer')


  @include('include2.Aside')
   <!-- /.control-sidebar -->
     <!-- Add the sidebar's background. This div must be placed
          immediately after the control sidebar -->
     <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

<script src="{{ asset('assets2/bower_components/jquery/dist/jquery.min.js') }}"></script>
<!-- Bootstrap 3.3.7 -->
<script src="{{ asset('assets2/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

<!-- DataTables -->
<script src="{{ asset('assets2/bower_components/datatables.net/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets2/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js') }}"></script>

<!-- bootstrap datepicker -->
<script src="{{ asset('assets2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<!-- SlimScroll -->
<script src="{{ asset('assets2/bower_components/jquery-slimscroll/jquery.slimscroll.min.js') }}"></script>
<!-- FastClick -->
<script src="{{ asset('assets2/bower_components/fastclick/lib/fastclick.js') }}"></script>

<!-- Select2 -->
<script src="{{ asset('assets2/bower_components/select2/dist/js/select2.full.min.js') }}"></script>

<!-- InputMask -->
<script src="{{ asset('assets2/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('assets2/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('assets2/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>

<!-- AdminLTE App -->
<script src="{{ asset('assets2/dist/js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->

@yield('jsContainer')

<script>

    $(document).ready(function () {
        $('.sidebar-menu').tree();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        load_pesan = function () {
            $.ajax({
                url:'{{ url('getMessage') }}',
                dataType : 'json',
                success: function (data) {
                    if(data.banyak_pesan>0){
                        $('#count_message').show();
                    }else{
                        $('#count_message').hide();
                    }
                    $('#message_').html(data.pesan);
                    $('#count_message').html(data.banyak_pesan)
                }
            })
        }

        readMessage = function(ll){
            $.ajax({
                url:'{{ url('getMessage') }}/'+ll,
                dataType : 'json',
                success: function(data){
                    load_pesan();
                    $('#_body_wkwkw').html(data.pesan);
                    $('#modal_Pesan').modal("show");
                }
            });
        }

        loadInfo = function(){
            $.ajax({
                url : '{{ url('infolangganan') }}',
                dataType: "JSON",
                success : function(result){
                    if(result.status_aktif == false)
                    {
                        //$('.adiktif').attr('href','#'); Masih Ada Bug Nya
                    }
                    loadTingkat();
                }
            });
        }

        loadTingkat = function () {
            $.ajax({
                url: "{{ url('getDataInstansi') }}",
                dataType : "Json",
                success: function (result) {
                    var tingkat = "Bidang";
                    if(result.tingkat==1){
                        tingkat = "Bidang"
                    }else if(result.tingkat == 2 || result.tingkat==3) {
                        tingkat = "Bagian"
                    }
                    $('#namaBidangs').html("<i class=\"fa fa-circle-o\"></i>"+tingkat)
                    $('#header_sektor').text("Halaman "+tingkat);
                    $('#table_header_sektor').text("Tabel "+tingkat);
                    $('#button_label_bidang').html("Tambah "+tingkat);
                }
            })
        }
        loadInfo();
        setInterval(function(){ load_pesan(); console.log("Sedang Berjalan");}, 600000);
       // setTimeout(function(){  loadInfo(); console.log("Sedang Berjalan");}, 5000);
       // setTimeout(function(){  loadTingkat(); console.log("Sedang Berjalan");}, 3000);

    });

  $(function () {
      //Initialize Select2 Elements
      $('.select2').select2()
      $('#example1').DataTable()
      $('#example1_habis').DataTable()
      $('#example2').DataTable({
          'paging'      : true,
          'lengthChange': false,
          'searching'   : false,
          'ordering'    : true,
          'info'        : true,
          'autoWidth'   : false
      })



      //Date picker
      $('#datepicker').datepicker({
          autoclose: true
      })
  });
</script>

</body>
</html>
