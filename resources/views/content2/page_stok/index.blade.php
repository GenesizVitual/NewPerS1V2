
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Sisa Barang
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
                        <h3 class="box-title">Sisa Barang</h3>
                        <div class="box-tools pull-right">
                        </div>
                    </div>
                    <div class="box-body">
                        <div class="table-responsive">
                            <div class="row">
                                <div class="col-md-12">
                                    <p style="color: red">
                                        Sub menu sisa barang digunakan untuk mengisi data sisa stok tahun lalu, ditahun anggaran yang aktif.
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  id="tahunAnggaran">
                                        <option > Pilih Tahun Anggaran </option>
                                        @foreach($tahun_anggaran as $value)
                                            <option value="{{ $value->id }}"> {{ $value->years }} </option>
                                        @endforeach
                                    </select>
                                </div>
                               <div class="col-md-6">
                                   <a href="{{ url('insertStok') }}" data-toggle="tooltip"  class="btn btn-primary ">Tambah Sisa Barang</a>
                                   <a href="{{ url('import_stok') }}" onclick="return confirm('Pastikan Tanggal Penerimaan pada stok barang adalah tahun lalu dan tahun anggaran aktif')" class="btn btn-danger ">Import Stok Ke Tahun {{ $tahun_anggaran_aktif->years -1 }}</a>
                                   <a href="{{ url('import_stok_tahun_mendatang') }}" onclick="return confirm('Apakah Anda Akan import stok barang anda ke tahun {{ $tahun_anggaran_aktif->years +1 }} ')" class=" btn btn-success ">Import Stok Ke tahun {{ $tahun_anggaran_aktif->years +1 }} </a>
                               </div>
                                <div class="col-md-12">
                                    <p style="color: green">
                                        @if(!empty(Session::get('message')))
                                            {{ Session::get('message') }}
                                        @endif
                                    </p>

                                </div>


                            </div>

                            <table class="table table-bordered table-striped" id="example3">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tanggal penerimaan</th>
                                    <th>Nama Barang</th>
                                    <th>Harga Satuan barang Saat itu</th>
                                    <th>Sisa</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
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

@section('jsContainer')
    <script>
        $(document).ready(function () {
            $('#tahunAnggaran').change(function () {
                $.ajax({
                    url:'{{ url('getDataStock') }}/'+$(this).val(),
                    dataType: 'json',
                }).done(function (result) {
                    console.log(result);
                    table_stok.clear().draw();
                    table_stok.rows.add(result.output).draw();
                }).fail(function(jqXHR, testStatus, errorThrown){

                })
            })

            table_stok = $('#example3').DataTable({
               data: [],
               column: [
                   {'data':'0'},
                   {'data':'1'},
                   {'data':'2'},
                   {'data':'3'},
               ],
                rowCallback: function (row, data) {

                },
                filter: false,
                pagging: true,
                searching: true,
                info: true,
                ordering: true,
                processing: true,
                retrive: true
            });

        })
    </script>
@stop