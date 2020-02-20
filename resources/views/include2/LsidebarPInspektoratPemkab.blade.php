<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('assets2/dist/img/user2-160x160.jpg') }}" class="img-circle" alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Session::get('nama') }}</p>
                <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- search form -->
        <form action="#" method="get" class="sidebar-form">
            <div class="input-group">
                <input type="text" name="q" class="form-control" placeholder="Search...">
                <span class="input-group-btn">
                <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
                </button>
              </span>
            </div>
        </form>
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li><a href="{{ url('halaman_inspektorat_pemkab') }}"><i class="fa fa-circle-o text-red"></i> <span>Akses</span></a></li>

            @if(Session::has('user_id'))
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Laporan</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('report_inspektorat_pemkabs/penerimaan') }}"><i class="fa fa-circle-o"></i> Penerimaan Barang</a></li>
                    <li><a href="{{ url('report_inspektorat_pemkab/pengeluaran') }}"><i class="fa fa-circle-o"></i> Pengeluaran Barang</a></li>
                    <li><a href="{{ url('report_inspektorat_pemkab/bph') }}"><i class="fa fa-circle-o"></i> Barang Pakai Habis</a></li>
                    <li><a href="{{ url('report/semester/inspekoratpemkab') }}"><i class="fa fa-circle-o"></i> Semester</a></li>
                    <li><a href="{{ url('report_inspektorat_pemkab_kb') }}"><i class="fa fa-circle-o"></i> Kartu Barang</a></li>
                    <li><a href="{{ url('get_mutasi_inspektorat_pemkab') }}"><i class="fa fa-circle-o"></i> Mutasi Persediaan</a></li>
                    <li><a href="{{ url('get_inspektorat_pemkab_stok_') }}"><i class="fa fa-circle-o"></i> Stok barang</a></li>
                    <li><a href="{{ url('get_inspektorat_pemkab_stok_opname_content') }}"><i class="fa fa-circle-o"></i> Stok Opname</a></li>
                    <li><a href="{{ url('laporan_perjenis_barang_inspektorat_pemkab') }}"><i class="fa fa-circle-o"></i>Rekap Rekapitulasi <br> Perjenis Barang</a></li>
                    <li><a href="{{ url('report_rekap_spj_inpektorat_pemkab') }}"><i class="fa fa-circle-o"></i>Rekap Rekapitulasi Persediaan</a></li>
                    <li><a href="{{ url('report_realisasi_pakai_habis_inspektorat_pemkab') }}"><i class="fa fa-circle-o"></i>Rekap Realisasi Pakai Habis</a></li>
                    <li><a href="{{ url('berita_acara_pemeriksaan_inspektorat_pemkab') }}"><i class="fa fa-circle-o"></i>Berita Acara Pemeriksaan <br> Persediaan</a></li>
                </ul>
            </li>
                <li><a href="{{ asset('panduan/inspektorat_kabupaten.pdf') }}"><i class="fa fa-circle-o text-red"></i> <span>Panduan</span></a></li>
                <li><a href="{{ url('keluar_pegawai_instansi_pemkab') }}"><i class="fa fa-circle-o text-red"></i> <span>Ganti SKPD</span></a></li>
           @endif
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
