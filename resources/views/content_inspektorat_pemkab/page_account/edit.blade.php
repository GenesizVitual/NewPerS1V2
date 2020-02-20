
@extends('master_inspektorat_pemkab')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Ubah Akun Pemeriksa Inspektorat Kabupaten
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Formulir</h3>
                </div>
                <form action="{{ url('editAdminInspektoratPemkab/'. $data->id) }}" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pengguna</label>
                            <input type="text" class="form-control" name="username" placeholder="Masukan Nama Pengguna" value="{{ $data->account }}">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Provinsi</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="provinsi">
                                <option > - </option>
                                @foreach($provinsi as $val)
                                    <option value="{{ $val->id }}" @if($data->province_id==$val->id) selected @endif> {{ $val->province }} </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Kabupaten</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="kabupaten">
                                <option > - </option>
                                @foreach($kabupaten as $val)
                                    <option value="{{ $val->id }}" @if($data->district_id==$val->id) selected @endif> {{ $val->district }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    {{ csrf_field() }}
                    <input type="hidden" name="_method" value="put">
                    <button type="submit" class="btn btn-primary pull-right"> Kirim</button>
                </div>
                </form>
                <!-- /.box-footer-->
            </div>
            <!-- /.box -->
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@stop