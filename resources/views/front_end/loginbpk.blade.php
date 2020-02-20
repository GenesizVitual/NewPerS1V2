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
							<div class="col-md-6" align="center">
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
	<!-- login bpk-->
	<section id="login-bpk" class="home-section bg-white">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h4>Selamat datang di</h4>
						<h4>Persediaan.id</h4>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-offset-1 col-md-10">
					@if(Session::has('message_success'))
						<p style="color: green">{{ Session::get('message_success') }} </p>
					@endif

					@if(Session::has('message_fail'))
						<p style="color: red">{{ Session::get('message_fail') }} </p>
					@endif
					<form class="form-horizontal" action="{{ url('login_bpk') }}" role="form" method="post">
					  <div  class="form-group {{ $errors->has('username') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="text" class="form-control"  name="username" placeholder="Nama Pengguna">
							<small class="text-danger">{{ $errors->first('username') }}</small>
						</div>
					  </div>
					  <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  <input type="Password" class="form-control"  placeholder="Password" name="password">
							<small class="text-danger">{{ $errors->first('password') }}</small>
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
					  <div  class="form-group {{ $errors->has('kabupaten') ? ' has-error' : '' }}">
						<div class="col-md-offset-3 col-md-6">
						  	<select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="kabupaten">
				            	<option> Pilih Kabupaten </option>
				            </select>
							<small class="text-danger">{{ $errors->first('kabupaten') }}</small>
						</div>
					  </div>
					  <div class="form-group checkbox-remember">
						<div class="col-md-offset-3 col-md-6">
							<div class="form-check">
								<label class="text-normal" align="justify">
									Pemeriksa BPK untuk mendapatkan akun persediaan.id, silahkan menghubungi admin BPK di masing-masing provinsi. <br>Pemeriksa Inspektorat untuk mendapatkan akun persediaan.id, silahkan menghubungi admin Inspektorat di masing-masing provinsi atau Kabupaten/Kota. Informasi lebih lanjut silahkan <a href="page#contact">menghubungi kami</a>
								</label>
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
	<!-- end login bpk-->
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