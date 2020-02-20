<!DOCTYPE html>
<html>
  <head>
    <title>Persediaan.id</title>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	  <link href="{{ asset('front_end/css/bootstrap.min.css') }}" rel="stylesheet" media="screen">
	  <link href="{{ asset('front_end/css/style.css') }}" rel="stylesheet" media="screen">
	  <link href="{{ asset('front_end/css/icon.css') }}" rel="stylesheet" media="screen">
	  <link href="{{ asset('front_end/color/default.css') }}" rel="stylesheet" media="screen">
	  <link id="favicon" rel="shortcut icon" href="{{ asset('assets2/bulat.png') }}" type="image/png">
	 <!--<script src="{{ asset('front_end/js/modernizr.custom.js') }}"></script>-->
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
	<!--<div class="menu-area">
		<div id="dl-menu" class="dl-menuwrapper">
			<button class="dl-trigger">Open Menu</button>
			<ul class="dl-menu">
				<li><a href="intro">Home</a></li>
				<li><a href="{{ url('page#aboutus') }}">Tentang Kami</a></li>
				<li><a href="{{ url('page#report') }}">Laporan</a></li>
				<li><a href="{{ url('page#works') }}">Cara Kerja</a></li>
				<li><a href="{{ url('page#contact') }}">Kontak</a></li>
			</ul>
		</div>
	</div>-->
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
						</div>
					</div>
					<div class="btn-row">
						<div class="row">
							<div class="col-md-3">&nbsp;</div>
							<div class="col-md-6" align="center">
								<a href="{{ url('page#intro') }}" class="btn-blue">Home</a>
								<span class="text-spacer">|</span>
								<a href="{{ url('login#login') }}" class="btn-blue">Login OPD</a>
							</div>
							<div class="col-md-3">&nbsp;</div>
		            	</div>
	                </div>
				</div>
			</div>
	 	</div>
	</div>
	<!-- login -->
	<section id="login" class="home-section bg-white">
	  	<div class="container">
			<div class="row">

			</div>
	  		<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>Selamat datang di</h4>
						<h4>Persediaan.id</h4>
						<p>Masukan username dan password anda</p>
						@if(Session::has('message_aktivasi'))
							<p style="color: green">{{ Session::get('message_aktivasi') }} </p>
						@endif
					</div>
				</div>
	  			<div class="col-md-offset-1 col-md-10">
					@if(Session::has('message_success'))
						<p style="color: green">{{ Session::get('message_success') }} </p>
					@endif

					@if(Session::has('message_fail'))
						<p style="color: red">{{ Session::get('message_fail') }} </p>
					@endif

					<form class="form-horizontal" role="form" action="{{ url('login') }}" method="post">
					  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}" >
						<div class="col-md-offset-3 col-md-6">
						  <input type="text" class="form-control" id="inputName" placeholder="Username" name="name">
							<small class="text-danger">{{ $errors->first('name') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="Password" class="form-control" id="inputName" placeholder="Password" name="password">
							<small class="text-danger">{{ $errors->first('password') }}</small>
						</div>
					  </div>
					  <div class="form-group checkbox-remember">
						<div class="col-md-offset-3 col-md-6">
							<div class="row">
								<div class="col-md-6 url-text-no-margin">
							  		<a href="{{ url('lupa-password') }}#lupa-password">Lupa Password?</a>
							  	</div>
							</div>
						</div>
					  </div>
					  <div class="form-group">
						<div class="col-md-offset-3 col-md-6">
							{{ csrf_field() }}
						 <button type="submit" class="btn btn-theme btn-lg btn-block">Login</button>
						</div>
					  </div>
					</form>
	  			</div>
		  </div>
		</div>
	</section>
	<!-- end login -->
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Copyright &copy;2018 Sumber Info Media All rights reserved.</p>
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
</html>