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
				<li><a href="#intro">Home</a></li>
				<li><a href="#aboutus">Tentang Kami</a></li>
				<li><a href="#report">Laporan</a></li>
				<li><a href="#works">Cara Kerja</a></li>
				<li><a href="#contact">Kontak</a></li>
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
								<a href="#intro" class="btn-blue">Home</a>
								<span class="text-spacer">|</span>
								<a href="{{ url('login#login') }}" class="btn-blue">Login OPD</a>
								<!--<span class="text-spacer">|</span>
								<a href="{{ url('daftar#bimtek') }}" class="btn-blue">BIMTEK</a>-->
							</div>
							<div class="col-md-3">&nbsp;</div>
		            	</div>
	                </div>
				</div>
			</div>
	 	</div>
	</div>
	<!-- about us -->
	 <section id="aboutus" class="home-section bg-white">
		<div class="container">
			  <div class="row">
				  <div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
					 <h2>Tentang Kami</h2>
					 <p>Kenapa Persediaan.id sangat mudah dan fleksibel penggunaannya?</p>
					</div>
				  </div>
			  </div>
			  <div class="row">
			  	<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.7s">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<span class="icon-invoice fa-4x"></span>
						<h4>SPJ, TBK &amp; Nota</h4>
						<p>Merupakan aplikasi persediaan barang pakai habis berbasis Program, Kegiatan & Belanja dari data SIMDA, Berbasis SPJ, TBK dan Nota</p>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<span class="icon-easy fa-4x"></span>
						<h4>Mudah digunakan</h4>
						<p>Aplikasi ini bisa digunakan oleh Semua OPD di seluruh Indonesia, baik OPD tingkat Provinsi maupun Kabupaten/Kota.
						   Metode penginputan persediaan fleksibel dapat menggunakan Basis Kas Maupun Basis Akrual.
						  </p>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.3s">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<span class="icon-report fa-4x"></span>
						<h4>Laporan Detail</h4>
						<p>Terdapat 16 jenis laporan persediaan, surat dan Berita Acara Persediaan 
						 berdasarkan Permendagri No.17 Tahun 2007, format laporan BPK dan laporan sesuai dengan kebutuhan masing-masing OPD.</p>
					</div>
                </div>
                <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.5s">
					<div class="service-box wow bounceInDown" data-wow-delay="0.1s">
						<span class="icon-investigate fa-4x"></span>
						<h4>Sangat transparan</h4>
						<p>Aplikasi ini mempermudah Inspektorat dan Badan Pemeriksa Keuangan (BPK) dalam melakukan pemeriksaan secara real time, menghemat anggaran karena paperless(tanpa kertas)</p>
					</div>
                </div>
			  </div>	
		</div>
	</section>
	<!-- report -->
	<section id="report" class="home-section spacer">
		<div class="container color-light">
			<div class="row">
			  <div class="col-md-offset-2 col-md-8">
				<div class="section-heading ">
				 <h2>Laporan</h2>
				 <p>Berikut ini adalah laporan yang dapat kami hasilkan :</p>
				</div>
			  </div>
			</div>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="box-team wow bounceInDown" data-wow-delay="0.1s">
					    <span class="icon-1 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Penerimaan Barang & Pengeluaran Barang</h6>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.3s">
					<div class="box-team wow bounceInDown">
					    <span class="icon-2 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Barang Pakai Habis & Semester</h6>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.5s">
					<div class="box-team wow bounceInDown">
					    <span class="icon-3 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Kartu Barang & Mutasi Persediaan</h6>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.7s">
					<div class="box-team wow bounceInDown">
					    <span class="icon-4 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Stok Barang & Rekapitulasi Persediaan</h6>
					</div>
				</div>
			</div>
			<br><br><br><br>
			<div class="row">
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
					<div class="box-team wow bounceInDown" data-wow-delay="0.1s">
					    <span class="icon-5 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Stok Opname & Rekapitulasi Penerimaan</h6>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.3s">
					<div class="box-team wow bounceInDown">
					    <span class="icon-6 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Surat Pesanan, Berita Acara Penerimaan, Surat Permintaan & Pengeluaran</h6>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.5s">
					<div class="box-team wow bounceInDown">
					    <span class="icon-7 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Rekapitulasi Persediaan & Realisasi Anggaran Persediaan </h6>
					</div>
				</div>
				<div class="col-xs-12 col-sm-3 col-md-3 col-lg-3" data-wow-delay="0.7s">
					<div class="box-team wow bounceInDown">
					    <span class="icon-8 fa-5x"></span>
					    <p>&nbsp;</p>
					    <h6>Laporan Persediaan LKPD</h6>
					</div>
				</div>
			</div>
		
			</div>			  
		</div>	  
	</section>
	 <!-- Works -->
	<section id="works" class="home-section">
		<div class="container">
			<div class="row">
			  <div class="col-md-offset-2 col-md-8">
				<div class="section-heading">
				 <h2>Cara Kerja</h2>
				 <p>Berikut adalah bagaimana alur aplikasi persediaan.id, sehingga dapat membantu anda</p>
				</div>
			  </div>
		  	</div>
		<div id="flow">
			</div>
		</div>
	</section>
	<!-- contact -->
	<section id="contact" class="home-section bg-gray">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h2>Kontak</h2>
						<p>Untuk info lebih lanjut, silahkan hubungi kami di : </p>
					</div>
				</div>
		  	</div>
			<div class="row">
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.1s">
					<div class="box-team wow bounceInDown">
						<span class="icon-phone fa-4x"></span>
		                <h6 class="mar-top10">0401–3083049</h6>
		                <h6>085-22-800-66-75</h6>
					</div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.3s">
					<div class="box-team wow bounceInDown">
			           	<span class="icon-whatsapp fa-4x"></span>
			            <h6 class="mar-top20">085-22-800-66-75</h6>
						
					</div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.5s">
					<div class="box-team wow bounceInDown">
		                <span class="icon-telegram"><span class="path1 fa-4x"></span><span class="path2 fa-4x"></span></span>
		                <h6 class="mar-top20">085-22-800-66-75</h6>
					</div>
		        </div>
		    </div>
		    <div class="row mar-top20">
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.7s">
					<div class="box-team wow bounceInDown">
						<span class="icon-facebook fa-4x"></span>
		                <h6 class="mar-top20">@persediaan.id</h6>
					</div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.9s">
					<div class="box-team wow bounceInDown">
			           	<span class="icon-email fa-4x"></span>
						<h6 class="mar-top20">cs@persediaan.id</h6>
			            <h6 class="mar-top20">info@persediaan.id</h6>
						
					</div>
		        </div>
		        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4" data-wow-delay="0.11s">
					<div class="box-team wow bounceInDown">
		                <span class="icon-home fa-4x"></span>
		                <h6 class="mar-top10">CV. Sumber Info Media</h6>
		                <h6>Jl. Pangeran Antasari 3</h6>
		                <h6>Kendari, Sultra</h6>
					</div>
		        </div>
			</div>			  
	  	</div>	  
	</section>
	
	<footer>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<p>Copyright &copy; 2018 Sumber Info Media All rights reserved</p>
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
<!--Start of Tawk.to Script-->
<script type="text/javascript">
var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
(function(){
var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
s1.async=true;
s1.src='https://embed.tawk.to/5bf4f72440105007f378eba1/default';
s1.charset='UTF-8';
s1.setAttribute('crossorigin','*');
s0.parentNode.insertBefore(s1,s0);
})();
</script>
<!--End of Tawk.to Script-->
</html>