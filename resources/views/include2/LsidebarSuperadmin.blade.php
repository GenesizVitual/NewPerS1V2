<!-- Left side column. contains the sidebar -->
<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="header">MAIN NAVIGATION</li>

            <li><a href="{{ url('#') }}"><i class="fa fa-circle-o text-red"></i> <span>Dashboard</span></a></li>
            <li><a href="{{ url('superadminbpk') }}"><i class="fa fa-circle-o text-red"></i> <span>Admin BPK</span></a></li>
            <li><a href="{{ url('superadminspektorat') }}"><i class="fa fa-circle-o text-red"></i> <span>Admin Inspektorat <br> PEMPROV</span></a></li>
            <li><a href="{{ url('superadmininspektoratPemkot') }}"><i class="fa fa-circle-o text-red"></i> <span>Admin Inspektorat <br> PEMKOT</span></a></li>
            <li><a href="{{ url('superadmininspektoratPemkab') }}"><i class="fa fa-circle-o text-red"></i> <span>Admin Inspektorat <br> PEMKAB</span></a></li>
            <li><a href="{{ url('pengguna_persediaan') }}"><i class="fa fa-circle-o text-red"></i> <span>Pengguna Persediaan</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Wilayah</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('provinsi') }}"><i class="fa fa-circle-o"></i> Provinsi </a></li>
                    <li><a href="{{ url('kabupaten') }}"><i class="fa fa-circle-o"></i> Kabupaten </a></li>
                </ul>
            </li>
            <li><a href="{{ url('tarif') }}"><i class="fa fa-circle-o text-red"></i> <span>Tarif</span></a></li>
            <li><a href="{{ url('daftar_langganan') }}"><i class="fa fa-circle-o text-red"></i> <span>Daftar Langganan</span></a></li>
            <li class="treeview">
                <a href="#">
                    <i class="fa fa-share"></i> <span>Pelatihan</span>
                    <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
                </a>
                <ul class="treeview-menu">
                    <li><a href="{{ url('jadwal_pel') }}"><i class="fa fa-circle-o"></i> Jadwal Pelatihan </a></li>
                    <li><a href="{{ url('waktu_pelatihan') }}"><i class="fa fa-circle-o"></i> Waktu Pelatihan </a></li>
                    <li><a href="{{ url('biaya_pel') }}"><i class="fa fa-circle-o"></i> Biaya Pelatihan </a></li>
                    <li><a href="{{ url('kupon') }}"><i class="fa fa-circle-o"></i> Kupon </a></li>
                    <li><a href="{{ url('list_registrasi_pelatihan') }}"><i class="fa fa-circle-o"></i> Daftar Registrasi Pelatihan </a></li>
                    <li><a href="{{ url('list_konfirmasi') }}"><i class="fa fa-circle-o"></i> Daftar Konfirmasi Pelatihan </a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
