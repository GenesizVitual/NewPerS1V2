
@extends('master_superadmin')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs pull-right">
                <li class="active"><a href="#tab_1-1" data-toggle="tab">Pengguna Sudah Konfirmasi</a></li>
                <li><a href="#tab_2-2" data-toggle="tab">Pengguna Belum Konfirmasi</a></li>
             </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1-1">
                    <div class="table-responsive" style="padding-top: 1%">

                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nip</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>SKPD</th>
                            </tr>
                            </thead>
                            <tbody>
                                @php($i=1)
                                @foreach($pengguna_sudah_konfirmasi as $value1)
                                    <tr>
                                        <th>{{ $i++ }}</th>
                                        <th>{{ $value1->name }}</th>
                                        <th>{{ $value1->nip }}</th>
                                        <th>{{ $value1->email }}</th>
                                        <th>{{ $value1->telp }}</th>
                                        <th>{{ $value1->getProvince->province }}</th>
                                        <th>{{ $value1->getDistrict->district }}</th>
                                         <th>{{ $value1->getInstansi->instance }}</th>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_2-2">
                    <div class="table-responsive" style="padding-top: 1%">

                        <table id="example1_habis" class="table table-bordered table-striped" style="width: 100%">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Nip</th>
                                <th>Email</th>
                                <th>Telp</th>
                                <th>Provinsi</th>
                                <th>Kabupaten</th>
                                <th>SKPD</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i=1)
                            @foreach($pengguna_belum_konfirmasi as $value1)
                                <tr>
                                    <th>{{ $i++ }}</th>
                                    <th>{{ $value1->name }}</th>
                                    <th>{{ $value1->nip }}</th>
                                    <th>{{ $value1->email }}</th>
                                    <th>{{ $value1->telp }}</th>
                                    <th>{{ $value1->getProvince->province }}</th>
                                    <th>{{ $value1->getDistrict->district }}</th>
                                   <th>{{ $value1->getInstansi->instance }}</th>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>.
                </div>
                <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3-2">
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry.
                    Lorem Ipsum has been the industry's standard dummy text ever since the 1500s,
                    when an unknown printer took a galley of type and scrambled it to make a type specimen book.
                    It has survived not only five centuries, but also the leap into electronic typesetting,
                    remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset
                    sheets containing Lorem Ipsum passages, and more recently with desktop publishing software
                    like Aldus PageMaker including versions of Lorem Ipsum.
                </div>
                <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>


        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

@stop

@section('jsContainer')
    <script>
        $(document).on(function () {
            alert("das");
        })
    </script>
@stop
