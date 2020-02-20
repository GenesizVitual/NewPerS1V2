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

            <li><a href="{{ url('dashboard') }}"><i class="fa fa-circle-o text-red"></i> <span>Dashboard</span></a></li>

            <li><a href="{{ url('profileInstansi') }}"><i class="fa fa-circle-o text-red"></i> <span>Profil Instansi</span></a></li>

            <li><a href="{{ url('createAccount') }}"><i class="fa fa-circle-o text-red"></i> <span>Buat Akun</span></a></li>

            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Pengaturan Awal</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('fiscalyears') }}"><i class="fa fa-circle-o"></i> Tahun Anggaran </a></li>
                    <li><a href="{{ url('sector') }}"><i class="fa fa-circle-o"></i> Bidang </a></li>
                    <li><a href="{{ url('authorized') }}"><i class="fa fa-circle-o"></i> Berwenang </a></li>
                    <li><a href="{{ url('dpa') }}"><i class="fa fa-circle-o"></i> DPA Anggaran </a></li>
                    <li><a href="{{ url('typeOfGoods') }}"><i class="fa fa-circle-o"></i> Jenis Barang </a></li>
                    <li><a href="{{ url('suppliers') }}"><i class="fa fa-circle-o"></i> Supplier </a></li>
                    <li><a href="{{ url('warehouse') }}"><i class="fa fa-circle-o"></i> Gudang Barang </a></li>
                    <li><a href="{{ url('stock') }}"><i class="fa fa-circle-o"></i> Stok Barang </a></li>
                </ul>
            </li>
            <li><a href="{{ url('goodsreceipt') }}"><i class="fa fa-circle-o text-red"></i> <span>SPJ</span></a></li>
            <li><a href="{{ url('expendures') }}"><i class="fa fa-circle-o text-red"></i> <span>Kelola Penerimaan</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Surat</span>
                    <span class="pull-right-container">
                         <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('letterofRequets') }}"><i class="fa fa-circle-o"></i> Surat Permintaan </a></li>
                    <li><a href="{{ url('letterofExpenditure') }}"><i class="fa fa-circle-o"></i> Surat Pengeluaran </a></li>
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
                    <li><a href="#"><i class="fa fa-circle-o"></i> Semester</a></li>
                    <li><a href="{{ url('report_kb') }}"><i class="fa fa-circle-o"></i> Kartu Barang</a></li>
                    <li><a href="{{ url('get_mutasi_') }}"><i class="fa fa-circle-o"></i> Mutasi Persediaan</a></li>
                    <li><a href="{{ url('get_stok_') }}"><i class="fa fa-circle-o"></i> Stok barang</a></li>
                    <li><a href="{{ url('get_stok_opname_content') }}"><i class="fa fa-circle-o"></i> Stok Opname</a></li>
                </ul>
            </li>
            <li><a href="{{ url('daftartagihan') }}"><i class="fa fa-circle-o text-red"></i><span>Langganan</span></a></li>
            <li><a href="{{ url('tiket_bantuan') }}"><i class="fa fa-circle-o text-red"></i><span>Tiket Bantuan</span></a></li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
