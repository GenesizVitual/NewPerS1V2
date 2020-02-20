
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Daftar yang telah konfirmasi
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Table Konfirmasi</h3>

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
                        <p></p>
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Kode Registrasi</th>
                                <th>Nama Peserta</th>
                                <th>Dari Bank</th>
                                <th>Nomor Rekening Perserta</th>
                                <th>Bank Tujuan</th>
                                <th>Nomor Rekeing Tujuan</th>
                                <th>Tanggal Bayar</th>
                                <th>Bukti</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($data_konfirmasi as $data)
                                <th>{{ $i++ }}</th>
                                <th>{{ $data->kode_registrasi }}</th>
                                <th>{{ $data->getPersertaByKode->nm_peserta }}</th>
                                <th>{{ $data->dari_bank }}</th>
                                <th>{{ $data->no_rek_p }}</th>
                                <th>{{ $data->bank_tujuan }}</th>
                                <th>{{ $data->no_rek_t }}</th>
                                <th>{{ date('d-m-Y', strtotime($data->tanggal_bayar)) }}</th>
                                <th><img src="{{ asset('file_rek/'.$data->bukti) }}" style="width: 80%; height: 50%;"></th>
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