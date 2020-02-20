
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Buat Kupon
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Tabel Kupon</h3>

                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse" data-toggle="tooltip"
                                title="Collapse">
                            <i class="fa fa-minus"></i></button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove" data-toggle="tooltip" title="Remove">
                            <i class="fa fa-times"></i></button>
                    </div>
                </div>
                <div class="box-body">
                    <div class="table-responsive" style="padding-top: 1%">
                        <a href="{{ url('create_kupon') }}" class="btn btn-primary">Tambah Kupon</a>
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Kupon</th>
                                <th>Nama Pemilik Kupon</th>
                                <th>Bulan Pelatihan</th>
                                <th>Waktu Pelatihan</th>
                                <th>Bonus Pemilik Kupon</th>
                                <th>Bonus Pemilik Kupon2</th>
                                <th>Bonus Peserta</th>
                                <th>Status</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data_kupon as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $data->kode_kupon }}</td>
                                        <td>{{ $data->pemilik_kupon }}</td>
                                        <td>{{ $data->getJadwalPel->bulan }}</td>
                                        <td>{{ date('d-m-Y', strtotime($data->getWaktuPel->date)) }}</td>
                                        <td>{!! $data->bonus_pemilik_kupon !!}</td>
                                        <td>{{ number_format($data->bonus_pemilik_kupon2,2,',','.') }}</td>
                                        <td>{!! $data->bonus_peserta  !!}</td>
                                        <td>
                                            @if($data->status_kupon=='0')
                                                Belum Digunakan
                                            @else
                                                <label style="color: green">Sudah digunakan</label>
                                            @endif
                                        </td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                    Footer
                </div>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->

        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop