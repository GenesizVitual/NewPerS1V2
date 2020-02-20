
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Surat Pesanan
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabel Surat Pesanan</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('buat_nota') }}" data-toggle="tooltip" title="Buat Nota Pesanan" class="mb-xs mt-xs mr-xs btn btn-primary"> Buat Surat Pesanan </a>
                            <p></p>
                            <table class="table mb-none" id="example1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Surat Pesanan</th>
                                    <th>Nama Belanja</th>
                                    <th>Suppliers</th>
                                    <th>Tanggal awal pesanan</th>
                                    <th>Tanggal Penyelesaian</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                    @foreach($data_nota as $data)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $data->nomor_surat }}</th>
                                            <th>{{ $data->get_belanja->name_belanja }}</th>
                                            <th>{{ $data->get_supplier->suppliers }}</th>
                                            <th>{{ date('d-m-Y', strtotime($data->tgl_awal_pekerjaan)) }}</th>
                                            <th>{{ date('d-m-Y', strtotime($data->tanggal_selesai_pekerjaan)) }}</th>
                                            <th>
                                                <a href="{{ url('rincian_barang/'.$data->id) }}" class="btn btn-primary" style="margin-bottom: 5px">Rician barang</a>
                                                <a href="{{ url('nota_p/'.$data->id.'/edit') }}" class="btn btn-warning" style="margin-bottom: 5px">Ubah Nota</a>
                                                <form method="post" action="{{ url('nota_p/'.$data->id.'/delete') }}">
                                                    {{ csrf_field() }}
                                                    <input name="_method" value="put" type="hidden">
                                                    <button type="submit" class="btn btn-danger" style="margin-bottom: 5px" onclick="return confirm('Apakah anda akan menghapus nota ini ..?')"> Hapus Nota </button>
                                                </form>
                                            </th>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                  </div>
            </div>
            <!-- /.box -->
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop