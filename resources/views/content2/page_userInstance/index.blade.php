
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman Buat Akun
                </h1>
            </section>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
            <div class="col-md-12" style="padding-bottom: 2%">
                <a href="{{ url('newAccount') }}" class="mb-xs mt-xs mr-xs btn btn-primary"><i class="fa fa-user"></i> Akun Baru</a>
            </div>


                @if(!empty($data_userinstansi))
                    @foreach($data_userinstansi as $data_user)
                    <div class="col-md-4">
                        <!-- Widget: user widget style 1 -->
                        <div class="box box-widget widget-user-2">
                            <!-- Add the bg color to the header using any of the bg-* classes -->
                            <div class="widget-user-header bg-yellow">
                                <div class="widget-user-image">
                                    <img class="img-circle" src="{{ asset('ManagementUserPhoto/'.$data_user->photo) }}" alt="User Avatar">
                                </div>
                                <!-- /.widget-user-image -->
                                <h3 class="widget-user-username">{{ $data_user->name }}</h3>
                                <h5 class="widget-user-desc">Penyimpan Barang</h5>

                            </div>
                            <div class="box-footer no-padding">
                                <ul class="nav nav-stacked">
                                    <li><a href="#">Nama Pengguna: {{ $data_user->username }}</a></li>
                                    <li>
                                        <div class="col-md-2" style="padding-bottom: 2%;padding-top: 2%">
                                            <a href="{{ url('newAccount/'.$data_user->id.'/edit') }}"  class="btn btn-danger"><i class="fa fa-fw fa-pencil-square"></i></a>
                                        </div>
                                        <div  class="col-md-2" style="padding-bottom: 2%;padding-top: 2%">
                                            <form action="{{ url('newAccount/'.$data_user->id.'/delete') }}" method="post">

                                                {{ csrf_field() }}
                                                <input type="hidden" name="foto" value="{{ $data_user->photo }}">
                                                <input type="hidden" name="_method" value="delete">
                                                <button type="submit" class="mb-xs mt-xs mr-xs modal-basic btn btn-danger" onclick="return confirm('Apakah anda yakin untuk menghapus Akun ini..?')"><i class="fa fa-fw fa-eraser"></i></button>
                                            </form>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /.widget-user -->
                    </div>
                    @endforeach
                @else
                <div class="col-md-12">
                    <div class="box">
                        <div class="callout callout-warning">
                            <h4>I am a warning callout!</h4>

                            <p>This is a yellow callout.</p>
                        </div>
                    </div>
                </div>
                @endif

            <!-- /.box --></div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop