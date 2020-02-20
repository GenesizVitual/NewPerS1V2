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
				<li><a href="{{ url('page#intro') }}">Home</a></li>
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
							<a href="{{ url('register#register') }}" class="btn btn-white btn-md">Coba sekarang Gratis</a>
						</div>
					</div>
					<div class="btn-row">
						<div class="row">
							<div class="col-md-3">&nbsp;</div>
							<div class="col-md-6">
								<a href="{{ url('page#intro') }}" class="btn-blue">Home</a>
								<span class="text-spacer">|</span>
								<a href="{{ url('register#register') }}" class="btn-blue">Daftar OPD</a>
								<span class="text-spacer">|</span>
								<a href="{{ url('login#login') }}" class="btn-blue">Login OPD</a>
								<span class="text-spacer">|</span>
								<a href="{{ url('loginbpk#login-bpk') }}" class="btn-blue">Login BPK/Inspektorat</a>
								<span class="text-spacer">|</span>
								<a href="{{ url('daftar#bimtek') }}" class="btn-blue">BIMTEK</a>
							</div>
							<div class="col-md-3">&nbsp;</div>
						</div>
	                </div>
				</div>
			</div>
	 	</div>
	</div>
	<!-- register -->
		<section id="register" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>Dapatkan akun di</h4>
						<h4>Persediaan.id</h4>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					@if(Session::has('message_fail'))
						<p style="color: red"> {{ Session::get('message_fail') }} </p>
					@endif

					<form class="form-horizontal" action="{{ url('signup') }}" role="form" method="post">
						{{ csrf_field() }}
					  <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="text" class="form-control" id="inputName" name="name" placeholder="Nama Lengkap">
							<small class="text-danger">{{ $errors->first('name') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('nip') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="text" class="form-control" id="inputName" name="nip" placeholder="NIP">
							<small class="text-danger">{{ $errors->first('nip') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="email" class="form-control" id="inputName" name="email" placeholder="Email">
							<small class="text-danger">{{ $errors->first('email') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="password" class="form-control" id="inputName" name="password" placeholder="Password">
							<small class="text-danger">{{ $errors->first('password') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('no_hp') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="text" class="form-control" id="inputName" name="no_hp" placeholder="Telepon/HP">
							<small class="text-danger">{{ $errors->first('no_hp') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('provinsi') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  	<select class="form-control select2 select2-hidden-accessible" name="provinsi">
		                    	<option> Pilih Provinsi </option>
								@foreach($provinsi as $val)
									<option value="{{ $val->id }}"> {{ $val->province }} </option>
								@endforeach
		                    </select>
							<small class="text-danger">{{ $errors->first('provinsi') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('kabupaten') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  	<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kabupaten">
		                    	<option> Pilih Kabupaten/Kota </option>
		                    </select>
							<small class="text-danger">{{ $errors->first('kabupaten') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('nama_skpd') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="text" class="form-control" id="inputName" name="nama_skpd" placeholder="Nama SKPD">
							<small class="text-danger">{{ $errors->first('nama_skpd') }}</small>
						</div>
					  </div>
						<div class="form-group checkbox-remember">
							<div class="col-md-offset-3 col-md-6">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="gridCheck" name="accepted">
									<label class="form-check-label" for="gridCheck">
										Saya sudah membaca dan setuju <a href="{{ url('syarat#terms-condition') }}" target="_blank">Syarat dan Ketentuan</a> penggunaan persediaan.id
									</label>
									<small class="text-danger">{{ $errors->first('accepted') }}</small>
								</div>
							</div>
						</div>
					  <div class="form-group">
						<div class="col-md-offset-3 col-md-6">
						 <button type="submit" class="btn btn-theme btn-lg btn-block">Register</button>
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
  
	<script>
		$(document).ready(function () {
			$('[name="provinsi"]').change(function () {
			    getKabupaten($(this).val())
            })
			
			getKabupaten = function (id) {
				$.ajax({
					url :"{{ url('getkabupaten') }}/"+id,
					dataType: "json",
					success: function (result) {
						$val = "";
					    $.each(result, function (index, value) {
							$val+="<option value='"+value.id+"'>"+ value.district +"</option>"
                        });
					    $('[name="kabupaten"]').html($val)
                    }
				})
            }
        })
	</script>
</html>