<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li><a href="{{ url('halaman_instasi_inspetorat') }}"><i class="fa fa-circle-o text-red"></i> <span>Akses</span></a></li>

            @if(Session::has('user_id'))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Laporan</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('report_inspektorat/penerimaan') }}"><i class="fa fa-circle-o"></i> Penerimaan Barang</a></li>
                    <li><a href="{{ url('report_inspektorat/pengeluaran') }}"><i class="fa fa-circle-o"></i> Pengeluaran Barang</a></li>
                    <li><a href="{{ url('report_inspektorat/bph') }}"><i class="fa fa-circle-o"></i> Barang Pakai Habis</a></li>
                    <li><a href="{{ url('report/semester/inspekorat') }}"><i class="fa fa-circle-o"></i> Semester</a></li>
                    <li><a href="{{ url('report_inspektorat_kb') }}"><i class="fa fa-circle-o"></i> Kartu Barang</a></li>
                    <li><a href="{{ url('get_mutasi_inspektorat') }}"><i class="fa fa-circle-o"></i> Mutasi Persediaan</a></li>
                    <li><a href="{{ url('get_inspektorat_stok_') }}"><i class="fa fa-circle-o"></i> Stok barang</a></li>
                    <li><a href="{{ url('get_inspektorat_stok_opname_content') }}"><i class="fa fa-circle-o"></i> Stok Opname</a></li>
                    <li><a href="{{ url('laporan_perjenis_barang_inspektorat') }}"><i class="fa fa-circle-o"></i>Rekap Rekapitulasi <br> Perjenis Barang</a></li>
                    <li><a href="{{ url('report_rekap_spj_inpektorat') }}"><i class="fa fa-circle-o"></i>Rekap Rekapitulasi Persediaan</a></li>
                    <li><a href="{{ url('report_realisasi_pakai_habis_inspektorat') }}"><i class="fa fa-circle-o"></i>Rekap Realisasi Pakai Habis</a></li>
                    <li><a href="{{ url('berita_acara_pemeriksaan_inspektorat') }}"><i class="fa fa-circle-o"></i>Berita Acara Pemeriksaan <br> Persediaan</a></li>
                </ul>
            </li>
                <li><a href="{{ asset('panduan/inspektorat_provinsi.pdf') }}"><i class="fa fa-circle-o text-red"></i> <span>Panduan</span></a></li>
                <li><a href="{{ url('keluar_pegawai_instansi') }}"><i class="fa fa-circle-o text-red"></i> <span>Ganti SPKD</span></a></li>
           @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
