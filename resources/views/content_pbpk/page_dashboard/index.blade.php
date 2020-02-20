
@extends('master_p_bpk')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Instansi Yang Anda Bisa Akses
            </h1>
         </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Instansi</h3>

                </div>
                <div class="box-body">
                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Instansi</th>
                                <th>Singkatan</th>
                                <th>Provinsi</th>
                                <th>Kota/Kabupaten</th>
                                <th>Alamat</th>
                                <th>No. Telp</th>
                                <th>Fax</th>
                                <th>Tingkat</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($index=1)
                                @foreach($data_instansi as $value)
                                    @if(!empty($value->getInstasi->instance))
                                    <tr>
                                        <th>{{ $index++ }}</th>
                                        <th>{{ $value->getInstasi->instance }}</th>
                                        <th>{{ $value->getInstasi->singkatan_instansi }}</th>
                                        <th>{{ $value->getInstasi->getProvince->province }}</th>
                                        <th>{{ $value->getInstasi->getDistrict->district }}</th>
                                        <th>{{ $value->getInstasi->alamat }}</th>
                                        <th>{{ $value->getInstasi->no_telp }}</th>
                                        <th>{{ $value->getInstasi->fax }}</th>
                                        <th>
                                            @if($value->getInstasi->tingkat==1)
                                                Provinsi
                                            @elseif($value->getInstasi->tingkat==2)
                                                Kabupaten
                                            @elseif($value->getInstasi->tingkat==3)
                                                Kota
                                            @endif
                                        </th>
                                        <th><a href="{{ url('lihatInstansi/'.$value->instansi_id)}}">Lihat</a> </th>
                                    </tr>
                                    @endif
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