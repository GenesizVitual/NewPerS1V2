
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman daftar berita acara penerimaan barang/jasa
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
                        <h3 class="box-title">Tabel berita acara penerimaan barang/jasa</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('tambah_berita_acara_penerimaan_barang_jasa') }}" data-toggle="tooltip" title="Buat berita acara penerimaan barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Buat berita acara penerimaan barang </a>
                            <p></p>
                            <table class="table mb-none" id="example1">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nomor Surat Berita Acara</th>
                                    <th>Nama Belanja</th>
                                    <th>Suppliers</th>
                                    <th>Tanggal Surat Berita Acara</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                    @foreach($data_nota as $data)
                                        <tr>
                                            <th>{{ $i++ }}</th>
                                            <th>{{ $data->nomor_berita_acara }}</th>
                                            <th>{{ $data->getBeritaAcaraPH->getNotaPesanan->get_belanja->name_belanja }}</th>
                                            <th>{{ $data->getBeritaAcaraPH->getNotaPesanan->get_supplier->suppliers }}</th>
                                            <th>{{ date('d-m-Y', strtotime($data->tgl_berita_acara)) }}</th>
                                            <th>
                                                <a href="{{ url('rincian_berita_acara/'.$data->id.'/detail') }}" class="btn btn-primary" style="margin-bottom: 5px">Lihat berita Acara</a>
                                                <a href="{{ url('berita_acara_penerimaan/'.$data->id.'/edit') }}" class="btn btn-warning" style="margin-bottom: 5px">Ubah Nota</a>
                                                <form method="post" action="{{ url('berita_acara_penerimaan/'.$data->id.'/delete') }}">
                                                    {{ csrf_field() }}
                                                    <input name="_method" value="put" type="hidden">
                                                    <button type="submit" class="btn btn-danger" style="margin-bottom: 5px" onclick="return confirm('Apakah anda akan menghapus Berita acara hasil pekerjaan ini ..?')"> Hapus Nota </button>
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