
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Berwenang
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
                        <h3 class="box-title">Tabel Berwenang</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <a href="{{ url('authorized/create') }}" data-toggle="tooltip"  class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Berwenang</a>
                            <table class="table mb-none">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>NIP</th>
                                    <th>Jabatan</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($index=1)
                                @foreach($berwenang as $berwenang)
                                    <tr>
                                        <td>{{ $index++ }}</td>
                                        <td>{{ $berwenang->nama_berwenang }}</td>
                                        <td>{{ $berwenang->nip }}</td>
                                        <td>
                                            @if($berwenang->level==1)
                                                Kepala Bidang
                                            @elseif($berwenang->level==2)
                                                Pengguna Barang
                                            @elseif($berwenang->level==3)
                                                Pengurus Barang
                                            @elseif($berwenang->level==4)
                                                Atasan Langsung
                                            @elseif($berwenang->level==5)
                                                Penyimpan Barang
                                            @elseif($berwenang->level==6)
                                                Pengguna Anggaran
                                            @elseif($berwenang->level==7)
                                                Kepala Dinas
                                            @elseif($berwenang->level==8)
                                                Pejabat Pengadaan
                                            @elseif($berwenang->level==9)
                                                PPK OPD
                                            @endif
                                        </td>
                                        <td>
                                            <form action="{{ url('authorized/'.$berwenang->id.'/destroy') }}" method="post">
                                                <a href="{{ url('authorized/'.$berwenang->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus Berwenang ini data dengan Bidang yang bersangkutan akan terhapus')">delete</button>
                                            </form>
                                        </td>
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