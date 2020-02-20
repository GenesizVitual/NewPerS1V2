<!DOCTYPE html>
<html>
  <head>
    <title>Persediaan.id</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <script src="{{ asset('assets2/bower_components/jquery/dist/jquery.min.js') }}"></script>
	  <link href="{{ asset('front_end/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	  <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" media="screen">
	  <link href="{{ asset('front_end/css/icon.css') }}" rel="stylesheet" media="screen">
	  <link href="{{ asset('front_end/color/default.css') }}" rel="stylesheet" media="screen">
	 <link id="favicon" rel="shortcut icon" href="{{ asset('assets2/bulat.png') }}" type="image/png">
	  <script src="{{ asset('front_end/js/modernizr.custom.js') }}"></script>
	  <!-- bootstrap datepicker -->
	  <link rel="stylesheet" href="{{ asset('assets2/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">
	<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145836956-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145836956-1');
</script>

  </head>
  <body>
	<div class="menu-area">
		<div id="dl-menu" class="dl-menuwrapper">
			<button class="dl-trigger">Open Menu</button>
			<ul class="dl-menu">
				<li><a href="{{ url('page#intro') }}">Home</a></li>
				<li><a href="{{ url('page#aboutus') }}">Tentang Kami</a></li>
				<li><a href="{{ url('page#report') }}">Laporan</a></li>
				<li><a href="{{ url('page#works') }}">Cara Kerja</a></li>
				<li><a href="{{ url('page#contact') }}">Kontak</a></li>
			</ul>
		</div>
	</div>
	<!-- home -->
	<div id="intro">
		<div class="intro-text">
			<div class="container">
				<div class="row">
					<div class="col-md-12">
						<div class="brand">
							<h1>Persediaan.id</h1>
							<div class="line-spacer"></div>
							<p><span>Aplikasi Persediaan Barang Pakai Habis</span></p>
<p><span>Basis Program, Kegiatan & Belanja</span></p>							
<p><span>Basis SPJ, TBK dan Nota</span></p>
							<a href="{{ url('register#register') }}" class="btn btn-white btn-md">Coba sekarang Gratis</a><br>
							<a href="{{ url('mendaftar_pelatihan#pelatihan') }}" class="btn btn-white btn-md">Ikut Pelatihan</a>
						</div>
					</div>
					<div class="btn-row">
						<div class="row">
							<div class="col-md-3">&nbsp;</div>
							<div class="col-md-6">
								<a href="{{ url('register#register') }}" class="btn-blue">Registrasi SKPD</a>
								<span class="text-spacer">&emsp;|&emsp;</span>
								<a href="{{ url('login#login') }}" class="btn-blue">Login SKPD</a>
								<span class="text-spacer">&emsp;|&emsp;</span>
								<a href="{{ url('loginbpk#login-bpk') }}" class="btn-blue">Login BPK/Inspektorat</a>
							</div>
							<div class="col-md-3">&nbsp;</div>
						</div>
	                </div>
				</div>
			</div>
	 	</div>
	</div>
	<!-- register -->
		<section id="pelatihan" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>Konfirmasi Pembayaran Pelatihan Anda</h4>
						<h4>Persediaan.id</h4>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					@if(Session::has('message_fail'))
						<p style="color: red"> {{ Session::get('message_fail') }} </p>
					@endif
						@if(Session::has('message_success'))
							<p style="color: red"> {{ Session::get('message_success') }} </p>
						@endif

					<form class="form-horizontal" action="{{ url('konfirmasi_pelatihan') }}" role="form" method="post" enctype="multipart/form-data">
						{{ csrf_field() }}
						<input type="hidden" name="kode_registrasi" value="{{ $kode_konfirmasi }}">
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('dari_bank') ? ' has-error' : '' }}">
									<label>Dari Bank :</label>
									<input type="text" class="form-control" id="dari_bank" name="dari_bank">
								</div>
							</div>
						</div>
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('no_rek_p') ? ' has-error' : '' }}">
									<label>No. Rekening Peserta </label>
									<input type="text" class="form-control" id="no_rek_p" name="no_rek_p">
								</div>
							</div>
						</div>
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('bank_tujuan') ? ' has-error' : '' }}">
									<label>Bank Tujuan</label>
									<input type="text" class="form-control" id="bank_tujuan" name="bank_tujuan"  value="Bank Muamalat" placeholder="Bank yang dituju" readonly>
								</div>
							</div>
						</div>
					<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('no_rek_t') ? ' has-error' : '' }}">
									<label>No. Rekening Tujuan</label>
									<input type="text" class="form-control" id="no_rek_t" name="no_rek_t"  value="8280001189"  readonly>
								</div>
							</div>
						</div>
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('tgl_bayar') ? ' has-error' : '' }}">
									<label>Tanggal Bayar</label>
									<input type="text" class="form-control" id="datepicker1" name="tgl_bayar" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
								</div>
							</div>
						</div>
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('jumlah_bayar') ? ' has-error' : '' }}">
									<label>Jumlah Bayar</label>
									<input type="text" class="form-control" id="jumlah_bayar" name="jumlah_bayar"  placeholder="Jumlah Bayar">
								</div>
							</div>
						</div>
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check {{ $errors->has('bukti') ? ' has-error' : '' }}">
									<label>Bukti Pembayaran</label>
									<input type="file" class="form-control" name="bukti" >
								</div>
							</div>
						</div>
					  <div class="form-group">
						<div class="col-md-offset-3 col-md-6">
						 <button type="submit" id="button_register" class="btn btn-theme btn-lg btn-block">Kirim</button>
						</div>
					  </div>
					</form>
				</div>
			</div>
		</div>
	</section> 
	<!-- end register -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Copyright &copy;2018 Sumber Info Media. All rights reserved.</p>
				</div>
			</div>		
		</div>	
	</footer>
	 <!-- js -->
	<script src="{{ asset('front_end/js/jquery.js') }}"></script>
	<script src="{{ asset('front_end/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('front_end/js/jquery.smooth-scroll.min.js') }}"></script>
	<script src="{{ asset('front_end/js/jquery.dlmenu.js') }}"></script>
	<script src="{{ asset('front_end/js/wow.min.js') }}"></script>
	<script src="{{ asset('front_end/js/custom.js') }}"></script>

	<!-- bootstrap datepicker -->
	<script src="{{ asset('assets2/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
	<!-- InputMask -->
	<script src="{{ asset('assets2/plugins/input-mask/jquery.inputmask.js') }}"></script>
	<script src="{{ asset('assets2/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
	<script src="{{ asset('assets2/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
	<script>
		$(document).ready(function () {
            $('#datepicker1').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker1').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })
        })
	</script>
</html>