
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Gudang
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="row">
            <div class="col-md-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title">Tabel Barang</h3>
                        <div class="box-tools pull-right">
                            <a href="{{ url('warehouse/create') }}" data-toggle="tooltip" title="Tambah Barang" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah Barang</a>
                            <a href="{{ asset('format_excel/Format_Import_Barang.xlsx') }}" data-toggle="tooltip" class="mb-xs mt-xs mr-xs btn btn-success"> Download Format Excel Barang</a>
                            <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                                Import Data barang
                            </button>
                        </div>
                    </div>
                    <div class="box-body">

                        <div class="table-responsive" style="padding-top: 1%">

                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kode Barang</th>
                                    <th>Nama Barang</th>
                                    <th>Jenis barang</th>
                                    <th>Satuan</th>
                                    <th>Spesifikasi</th>
                                    <th>Merek</th>
                                    {{--<th>Stok Minimal</th>--}}
                                    {{--<th>Stok Awal</th>--}}
                                    <th>Standar harga barang</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                @foreach($warehouse as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $data->goods_code }}</td>
                                        <td>{{ $data->goods_name }}</td>
                                        <td>{{ $data->jenis_barang->typeOfGoods }}</td>
                                        <td>{{ $data->unit}}</td>
                                        <td>{{ $data->specs}}</td>
                                        <td>{{ $data->brand}}</td>
                                        {{--<td>{{ $data->minimum_stock}}</td>--}}
                                        {{--<td>{{ $data->initial_stock}}</td>--}}
                                        <td>{{ number_format($data->standard_price,2,',','.')}}</td>
                                        <td>
                                            <form action="{{ url('warehouse/'.$data->id.'/delete') }}" method="post">
                                                <a href="{{ url('warehouse/'.$data->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                {{ csrf_field() }}
                                                <input type="hidden" name="_method" value="put">
                                                <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah Anda yakin akan menghapus barang ini data dengan barang yang bersangkutan akan terhapus')">hapus</button>
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

    <div class="modal fade" id="modal-default" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Panel Import Barang</h4>
                </div>
                <form action="{{ url('import-data-barang') }}" method="post" enctype="multipart/form-data">
                    <div class="modal-body">
                        <p>Jika anda ingin mengimport data barang. anda harus mendownload terlebih dahulu format import yang
                        telah ditentukan</p>

                            <div class="row">
                                <div class="col-md-12">
                                        <input type="file" class="form-control" required name="file">
                                </div>
                            </div>
                        {{ csrf_field() }}
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda akan melakukan import data barang anda..?')">Save changes</button>
                    </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
    <!-- /.content-wrapper -->
@stop