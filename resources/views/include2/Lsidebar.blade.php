<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            
            <li><a href="{{ url('dashboard') }}"><i class="fa fa-circle-o text-red"></i> <span>Dashboard</span></a></li>


            {{--<li><a href="{{ url('createAccount') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i> <span>Buat Akun</span></a></li>--}}

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Pengaturan Awal</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('profileInstansi') }}" class="adiktif"><i class="fa fa-circle-o"></i> <span>Profil Instansi</span></a></li>
                    <li><a href="{{ url('fiscalyears') }}" ><i class="fa fa-circle-o"></i> Tahun Anggaran </a></li>
                    <li><a href="{{ url('sector') }}"><i class="fa fa-circle-o"></i>Bidang</a></li>
                    <li><a href="{{ url('authorized') }}" ><i class="fa fa-circle-o"></i> Berwenang </a></li>
                    <!--<li><a href="{{ url('dpa') }}" ><i class="fa fa-circle-o"></i> DPA Persediaan </a></li>-->
                    <li><a href="{{ url('typeOfGoods') }}" ><i class="fa fa-circle-o"></i> Jenis Barang </a></li>
                    <li><a href="{{ url('suppliers') }}" ><i class="fa fa-circle-o"></i> Supplier </a></li>
                    <li><a href="{{ url('warehouse') }}" class="adiktif"><i class="fa fa-circle-o"></i> Gudang Barang </a></li>
                    <li><a href="{{ url('stock') }}" class="adiktif"><i class="fa fa-circle-o"></i> Sisa Barang </a></li>
                </ul>
            </li>
			
            <li class="treeview">
			<a href="#">
                    <i class="fa fa-share"></i> <span>DPA Persediaan</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
				<ul class="treeview-menu">
                    <li><a href="{{ url('dpa') }}" class="adiktif"><i class="fa fa-circle-o"></i>DPA</a></li>
                    <li><a href="{{ url('program') }}" class="adiktif"><i class="fa fa-circle-o"></i> Program,Kegiatan & Belanja</a></li>
                </ul>
			</li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Nota Pesanan</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('nota_p') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i> <span>Surat Pesanan</span></a></li>
                    <li><a href="{{ url('daftar_berita_acara_penerimaan_hasil_pekerjaan') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i><span>Berita Acara Hasil <br> Penerimaan Barang</span></a></li>
                    <li><a href="{{ url('berita_acara_penerimaan_barang_jasa') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i><span>Berita Acara Penerimaan <br>Barang</span></a></li>
                    <li><a href="{{ url('berita_acara_serah_terima_pekerjaan_pembelian') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i><span>Berita Acara Serah Terima<br>Pekerjaan</span></a></li>
                </ul>
            </li>
			<li><a href="{{ url('goodsreceipt') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i> <span>SPJ</span></a></li>
            <li><a href="{{ url('expendures') }}" class="adiktif"><i class="fa fa-circle-o text-red"></i> <span>Kelola Penerimaan</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Surat</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('letterofRequets') }}" class="adiktif"><i class="fa fa-circle-o"></i> Surat Permintaan </a></li>
                    <li><a href="{{ url('letterofExpenditure') }}" class="adiktif"><i class="fa fa-circle-o"></i> Surat Pengeluaran </a></li>
                </ul>
            </li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Laporan</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('report/penerimaan') }}"><i class="fa fa-circle-o"></i> Penerimaan Barang</a></li>
                    <li><a href="{{ url('report/pengeluaran') }}"><i class="fa fa-circle-o"></i> Pengeluaran Barang</a></li>
                    <li><a href="{{ url('report/bph') }}"><i class="fa fa-circle-o"></i> Barang Pakai Habis</a></li>
                    <li><a href="{{ url('report/semester') }}"><i class="fa fa-circle-o"></i> Semester</a></li>
                    <li><a href="{{ url('report_kb') }}"><i class="fa fa-circle-o"></i> Kartu Barang</a></li>
                    <li><a href="{{ url('get_mutasi_') }}"><i class="fa fa-circle-o"></i> Mutasi Persediaan</a></li>
                    <li><a href="{{ url('get_stok_') }}"><i class="fa fa-circle-o"></i> Stok barang</a></li>
                    <li><a href="{{ url('get_stok_opname_content') }}"><i class="fa fa-circle-o"></i> Stok Opname</a></li>
                    <li><a href="{{ url('laporan_perjenis_barang') }}"><i class="fa fa-circle-o"></i>Rekapitulasi Penerimaan <br> Perjenis Barang</a></li>
                    <li><a href="{{ url('report_rekap_spj') }}"><i class="fa fa-circle-o"></i>Rekapitulasi Persediaan</a></li>
                    <li><a href="{{ url('report_realisasi_pakai_habis') }}"><i class="fa fa-circle-o"></i>Realisasi Anggaran Persediaan</a></li>
                    <li><a href="{{ url('berita_acara_pemeriksaan') }}"><i class="fa fa-circle-o"></i>Berita Acara Pemeriksaan <br> Persediaan</a></li>
                    <li><a href="{{ url('laporan-permintaan-bpk') }}"><i class="fa fa-circle-o"></i>Mutasi Tambah Kurang</a></li>
                </ul>
            </li>
            {{--<li><a href="{{ url('tiket_bantuan') }}"><i class="fa fa-circle-o text-red"></i><span>Tiket Bantuan</span></a></li>--}}
            <li><a href="{{ asset('panduan/skpd.pdf') }}"><i class="fa fa-circle-o text-red"></i><span>Unduh Panduan</span></a></li>
		{{--<li class="treeview">--}}
			{{--<a href="#">--}}
                    {{--<i class="fa fa-share"></i> <span>Member</span>--}}
                    {{--<span class="pull-right-container">--}}
                         {{--<i class="fa fa-angle-left pull-right"></i>--}}
                    {{--</span>--}}
                {{--</a>--}}
				{{--<ul class="treeview-menu">--}}
                    {{--<li><a href="{{ url('memberbiasa') }}" class="adiktif"><i class="fa fa-circle-o"></i> Member Umum</a></li>--}}
                    {{--<li><a href="{{ url('daftartagihan') }}" class="adiktif"><i class="fa fa-circle-o"></i> Member Premium </a></li>--}}
                {{--</ul>--}}
		{{--</li>--}}

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>

