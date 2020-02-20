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
	<!-- terms-condition -->
	 <section id="terms-condition" class="home-section">
		<div class="container">
			<div class="row">
				<div class="col-md-offset-2 col-md-8">
					<div class="section-heading">
						<h2><b>Syarat dan Ketentuan</b></h2>
					</div>
				</div>
			<div class="row left-align">
				<div class="col-md-offset-2 col-md-8">
					<p align="justify">Syarat dan Ketentuan dalam dokumen ini menggambarkan dan menetapkan ketentuan yang mengatur serta mengendalikan hubungan hukum antara CV. Sumber Info Media selaku penyedia aplikasi persediaan.id selanjutnya di sebut Persediaan.id  dan Satuan Kerja Perangkat Daerah (SKPD) / Organisasi Perangkat Daerah (OPD) sebagai pengguna dari layanan pengelolaan sistem informasi persediaan barang pakai habis selanjutnya di sebut User.</p>
					<p align="justify">Sebelum mendaftar dan menggunakan persediaan.id, User harus membaca Syarat dan Ketentuan ini dengan seksama dan teliti.</p>
					<p>
					<ol class="upper-alpha">
						<li><b>Informasi Umum</b>
							<ol class="decimal">
								<li>Persediaan.id adalah aplikasi persediaan barang pakai habis yang dimiliki dan dioperasikan oleh CV. Sumber Info Media.</li>
								<li>Persediaan.id  berbasis Cloud dan dapat digunakan dimana dan kapan saja dengan ketersediaan koneksi internet.</li>
								<li>Persediaan.id merupakan aplikasi satu pintu antara SKPD/OPD sebagai pengguna, Inspektorat dan Badan Pemeriksa Keuangan (BPK) sebagai pemeriksa, yang berfungsi sebagai:
									<ol class="lower-alpha">
										<li>Pengelolaan data Barang Pakai Habis oleh Satuan Kerja Perangkat Daerah (SKPD) atau Organisasi Perangkat Daerah (OPD) baik tingkat Provinsi maupun tingkat Kabupaten / Kota di seluruh wilayah Republik Indonesia.</li>
										<li>Pemeriksaan data Barang Pakai Habis oleh:
											<ol class="lower-roman">
												<li>Inspektorat sebagai SKPD/OPD yang melakukan pemeriksaan laporan persediaan setiap SKPD/OPD pada tingkat provinsi, kabupaten/Kota.</li>
												<li>Badan Pemeriksa Keuangan (BPK) yang melakukan pemeriksaan  laporan persediaan setiap SKPD/OPD pada tingkat provinsi, kabupaten/Kota.</li>
											</ol>
										</li>
									</ol>
								</li>
								<li>Pengelolaan data pada Persediaan.id berbasis Surat Pertanggung Jawaban (SPJ), Tanda Bukti Kas (TBK) dan Nota pembelian barang pakai habis.</li>
								<li>Keluaran dari Persediaan.id berdasarkan format Laporan Permendagri No. 17 Tahun 2007 tentang Pengelolaan Barang Pakai Habis.</li>
								<li>Keluaran dari Persediaan.id terdiri dari:
									<ol class="lower-alpha">
										<li>Laporan Penerimaan</li>
										<li>Laporan Pengeluaran</li>
										<li>Laporan Barang Pakai Habis</li>
										<li>Laporan Semester</li>
										<li>Laporan Kartu Barang</li>
										<li>Laporan Mutasi Persediaan</li>
										<li>Laporan Stok Opname</li>
										<li>Laporan Rekapitulasi Persediaan</li>
									</ol>
								</li>
								<li>Persediaan.id bersifat gratis untuk :
									<ol class="lower-alpha">
										<li>Inspektorat dan BPK sebagai Pemeriksa, gratis tanpa syarat dan ketentuan.</li>
										<li>SKPD/OPD, dengan syarat dan ketentuan sesuai dengan jenis User.</li>
									</ol>
								</li>
								<li>User Persediaan.id merupakan member dari Persediaan.id. Jenis Member pada Persediaan.id terdiri dari:
									<ol class="lower-alpha">
										<li>Member umum
											<ol class="lower-roman">
												<li>Adalah user yang menggunakan Persediaan.id dihitung sejak mulai Registrasi pada Persediaan.id</li>
												<li>User umum mendapatkan fasiitas berupa penyimpanan data untuk yang terdiri dari:</li>
													<ol class="decimal">
														<li>Data Instansi tak terbatas (unlimited)</li>
														<li>Data Tahun Anggaran tak terbatas (unlimited)</li>
														<li>Data Nama - Nama Bidang / Bagian tak terbatas (unlimited)</li>
														<li>Data Pejabat Berwenang tak terbatas (unlimited)</li>
														<li>Data DPA Persediaan tak terbatas (unlimited)</li>
														<li>Data Jenis Barang tak terbatas (unlimited)</li>
														<li>Data nama-nama Supplier (penyedia) tak terbatas (unlimited)</li>
														<li>Data nama-nama barang persediaan tak terbatas (unlimited)</li>
														<li>Data SPJ tak terbatas (unlimited)</li>
														<li>Data TBK tak terbatas (unlimited)</li>
														<li>Data Penerimaan Barang terbatas (limited) sebanyak 100 data transaksi</li>
														<li>Data Pengeluaran tak terbatas (unlimited) untuk semua data pengeluaran mengacu pada data penerimaan</li>
														<li>Data Surat Permintaan tak terbatas (unlimited) untuk semua data pengeluaran mengacu pada data penerimaan </li>
														<li>Data Surat Pengeluaran tak terbatas (unlimited) untuk semua data pengeluaran mengacu pada data penerimaan </li>
													</ol>
												<li>Member umum dapat mengakses dan melakukan pencetakan pada laporan:</li>
													<ol class="decimal">
														<li>Penerimaan Barang</li>
														<li>Pengeluaran Barang</li>
														<li>Barang Pakai Habis</li>
														<li>Semester</li>
														<li>Kartu Barang</li>
														<li>Mutasi Persediaan</li>
														<li>Stok Barang</li>
														<li>Stok Opname</li>
														<li>Rekapitulasi Persediaan</li>
													</ol>
												<li>Konsultasi menyeluruh tentang implementasi aplikasi persediaan baik secara offline maupun on line</li>
												<li>Perbaikan kesalahan input data persediaan</li>
												<li>Perbaikan kesalahan laporan persediaan</li>
												<li>Pendampingan cara melakukan input data persediaan yang sesuai dengan alur aplikasi dan penyesuaian terhadap ketidaksesuaian data manual.</li>
												<li>Pengecekkan validitas laporan persediaan barang yang dihasilkan oleh penyimpan barang.</li>
												<li>Perbaikan kesalahan prosedur input data untuk semua jenis barang pakai habis.</li>
												<li>Penambahan fitur – fitur baru (update) aplikasi sesuai dengan kebutuhan semua SKPD</li>
												<li>Pemeliharaan aplikasi persediaan baik dari sisi aplikasi maupun server</li>
												<li>Backup data persediaan.id setiap hari.</li>
											</ol>
										</li>
										<li>Member Premium
											<ol class="lower-roman">
												<li>Adalah user yang menggunakan Persediaan.id dihitung sejak mulai Registrasi pada Persediaan.id</li>
												<li>User umum mendapatkan fasiitas berupa penyimpanan data untuk yang terdiri dari:</li>
													<ol class="decimal">
														<li>Data Instansi tak terbatas (unlimited)</li>
														<li>Data Tahun Anggaran tak terbatas (unlimited)</li>
														<li>Data Nama - Nama Bidang / Bagian tak terbatas (unlimited)</li>
														<li>Data Pejabat Berwenang tak terbatas (unlimited)</li>
														<li>Data DPA Persediaan tak terbatas (unlimited)</li>
														<li>Data Jenis Barang tak terbatas (unlimited)</li>
														<li>Data nama-nama Supplier (penyedia) tak terbatas (unlimited)</li>
														<li>Data nama-nama barang persediaan tak terbatas (unlimited)</li>
														<li>Data SPJ tak terbatas (unlimited)</li>
														<li>Data TBK tak terbatas (unlimited)</li>
														<li>Data Penerimaan Barang terbatas (unlimited)</li>
														<li>Data Pengeluaran tak terbatas (unlimited)</li>
														<li>Data Surat Permintaan tak terbatas (unlimited)</li>
														<li>Data Surat Pengeluaran tak terbatas (unlimited) </li>
													</ol>
												<li>Member Premium dapat mengakses dan melakukan pencetakan pada laporan:</li>
													<ol class="decimal">
														<li>Penerimaan Barang</li>
														<li>Pengeluaran Barang</li>
														<li>Barang Pakai Habis</li>
														<li>Semester</li>
														<li>Kartu Barang</li>
														<li>Mutasi Persediaan</li>
														<li>Stok Barang</li>
														<li>Stok Opname</li>
														<li>Rekapitulasi Persediaan</li>
													</ol>
												<li>Konsultasi menyeluruh tentang implementasi aplikasi persediaan baik secara offline maupun on line</li>
												<li>Perbaikan kesalahan input data persediaan</li>
												<li>Perbaikan kesalahan laporan persediaan</li>
												<li>Pendampingan cara melakukan input data persediaan yang sesuai dengan alur aplikasi dan penyesuaian terhadap ketidaksesuaian data manual.</li>
												<li>Pengecekkan validitas laporan persediaan barang yang dihasilkan oleh penyimpan barang.</li>
												<li>Perbaikan kesalahan prosedur input data untuk semua jenis barang pakai habis.</li>
												<li>Penambahan fitur – fitur baru (update) aplikasi sesuai dengan kebutuhan semua SKPD</li>
												<li>Pemeliharaan aplikasi persediaan baik dari sisi aplikasi maupun server</li>
												<li>Backup data persediaan.id setiap hari.</li>
											</ol>
											<li>Kewajiban Member Premium yaitu:
													<ol class="decimal">
														<li>Membuat tagihan dan pembayaran sesuai dengan paket yang dipilih sebagai premium member.</li>
														<li>Menghormati Hak kekayaan Intelektual Persediaan.id. Semua Hak Kekayaan Intelektual dalam Persediaan.id ini dimiliki oleh CV. Sumber Info Media. Semua informasi dan bahan, termasuk namun tidak terbatas pada, perangkat lunak, teks, data, grafik, citra, merek dagang, logo, ikon, kode html dan kode lainnya dalam Website ini dilarang untuk dipublikasikan, dimodifikasi, disalin, direproduksi, digandakan atau diubah dengan cara apa pun tanpa izin yang dinyatakan oleh CV. Sumber Info Media. Jika User melanggar hak-hak ini, CV. Sumber Info Media berhak untuk membuat gugatan perdata untuk jumlah keseluruhan kerusakan atau kerugian yang diderita. Pelanggaran-pelanggaran ini juga bisa merupakan tindak pidana sebagaimana diatur oleh peraturan perundang-undangan yang berlaku.</li>
													</ol>
											</li>
										</li>
									</ol>
								</li>
							</ol>
						</li>
						<li><b>Kewajian Penyedia</b>
							<ol class="lower-alpha">
								<li>Persediaan.id wajib menjaga keberlangsungan Persediaan.id.</li>
								<li>Persediaan.id wajin menjaga keamanan dan kerahasiaan data Persediaan.id.</li>
								<li>Persediaan.id wajib menyediakan layanan untuk kesuksesan proses implementasi Persediaan.id bagi semua User Persediaan.id.</li>
							</ol>
						</li>
						<li><b>Perjanjian Tingkat Layanan</b>
							<ol class="lower-alpha">
								<li>Target Ketersediaan Layanan
									Persediaan.id memberikan jaminan sehubungan dengan uptime sistem untuk 99,8 % untuk setiap bulan kalender.
								</li>
								<li>Pengecualian <br>
									Perhitungan uptime tidak termasuk:
									<ol class="lower-roman">
										<li>Penggunaan layanan oleh User dengan cara yang tidak diizinkan dalam Perjanjian ini atau cara yang berlaku;</li>
										<li>Masalah internet umum, kejadian force majeure atau faktor lain di luar kendali Gadjian;</li>
										<li>Peralatan User termasuk namun tidak terbatas pada perangkat lunak, koneksi jaringan atau infrastruktur lainnya;</li>
										<li>Sistem, tindakan atau kelalaian pihak ketiga; atau pemeliharaan terjadwal atau perawatan darurat yang wajar.</li>
									</ol>
								</li>
							</ol>
						</li>
						<li><b>Hubungan Dengan Pihak Ketiga</b>
							<ol class="lower-alpha">
								<li>Pihak ketiga adalah selain User Persediaan.id yaitu SKPD/OPD, Inspektorat dan BPK.</li>
								<li>Persediaan.id  tidak akan memberikan Data User kepada pihak ketiga tanpa persetujuan User.</li>
								<li>Persediaan.id  tidak bertanggung jawab atas layanan pihak ketiga yang bermitra dengan Gadjian.</li>
								<li>Seluruh resiko yang terjadi apabila diakibatkan oleh layanan pihak ketiga yang bermitra dengan Persediaan.id merupakan tanggung jawab pihak ketiga.</li>
							</ol>
						</li>
						<li><b>Transmisi Elektronik</b> <br>
							<p align="justify">Syarat dan Ketentuan ini, dan setiap amandemennya, dengan cara apa pun yang diterima, harus diperlakukan sebagai kontrak sebagaimana mestinya dan harus dianggap memiliki akibat hukum yang mengikat sama seperti versi asli yang ditandatangani secara langsung.</p>
						</li>
						<li><b>Force Majure </b><br>
							<p align="justify">Dalam hal ini apabila Persediaan.id  tidak dapat melaksanakan kewajiban baik sebagian maupun seluruhnya yang diakibatkan oleh hal-hal diluar kekuasaan atau kemampuan Persediaan.id, termasuk namun tidak terbatas pada bencana alam, perang, huru-hara, adanya larangan pemerintah yang tidak memperbolehkan Persediaan.id untuk beroperasi dibawah jurisdiksi hukum Indonesia, serta kejadian-kejadian atau peristiwa-peristiwa diluar kekuasaan atau kemampuan Persediaan.id, maka dengan ini User membebaskan Persediaan.id dalam segala macam tuntutan dalam bentuk apapun terkait dengan hal tersebut. </p>
						</li>
						<li><b>Penyelesaian Sengketa </b><br>
							<ol class="lower-alpha">
								<li><p align="justify">Dalam hal terjadi sengketa atau perselisihan yang timbul dari atau sehubungan dengan Syarat dan Ketentuan ini, kedua Pihak akan pertama-tama membahas dengan itikad baik untuk mencapai penyelesaian damai dalam waktu 30 (tiga puluh) Hari Kerja sejak tanggal pemberitahuan perselisihan. Namun, jika perselisihan tersebut tidak dapat diselesaikan melalui musyawarah dalam waktu 30 (tiga puluh) Hari Kerja, maka sengketa atau perselisihan tersebut akan dibawa ke Pengadilan Negeri Kota Kendari.</p></li>
								<li>Syarat dan Ketentuan ini menggunakan hukum atau jurisdiksi negara Republik Indonesia.</li>
							</ol>
						</li>
						<li><b>Ketentuan Lain – Lain</b>
							<ol class="lower-alpha">
								<li>Disclaimer
									<ol class="lower-roman">
										<li>Persediaan.id dalam hal ini tidak bertanggung jawab terhadap segala macam bentuk kelalaian yang dilakukan oleh User.</li>
										<li>Dengan menggunakan layanan Gadjian, User secara otomatis mengikuti sistem yang terdapat pada fitur-fitur layanan Persediaan.id.</li>
										<li><p align="justify">User bertanggung jawab untuk memastikan kebenaran, keabsahan dan kejelasan dokumen-dokumen untuk pendaftaran Persediaan.id, dan dengan ini User membebaskan Persediaan.id dari segala gugatan, tuntutan dan atau ganti rugi dari pihak manapun sehubungan dengan ketidakbenaran informasi, Data, keterangan, kewenangan dan atau kuasa yang diberikan oleh User.</p></li>
										<li><p align="justify">Apabila ada perbedaan interpretasi bahasa dalam syarat dan ketentuan ini, maka yarat dan ketentuan versi bahasa Indonesia yang akan berlaku.</p></li>
									</ol>
								</li>
							</ol>
						</li>
						<li><b>Perubahan </b><br>
							<p align="justify">Dengan memberikan pemberitahuan sebelumnya kepada User, sesuai dengan ketentuan yang berlaku, User dengan ini setuju bahwa setiap saat Persediaan.id berhak mengubah maupun memperbaiki, menambah atau mengurangi ketentuan dalam Syarat dan Ketentuan terikat pada seluruh perubahan yang dilakukan oleh Persediaan.id.</p>
						</li>
						<li><b>Komunikasi</b> <br>
							<p align="justify">
								User dapat menghubungi pihak Persediaan.id melalui:
								<br>
								Email : info@persediaan.id
								<br>
								Telepon : 0401-3083049, 085228006675
								<br>
								Kantor Persediaan.id
								<br>
								Jl. Pangeran Antasari No 3 Poasia, Kendari, Sultra – Indonesia
							</p>
						</li>
					</ol>
					</p>
				</div>
			</div>
			<div class="row left-align">
				<div class="col-md-offset-2 col-md-8">
					<p>Dengan menggunakan persediaan.id, User mengakui bahwa User telah membaca, memahami, dan menyetujui Syarat dan Ketentuan ini.</p>
				</div>
			</div>
		</div>
	</section>
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