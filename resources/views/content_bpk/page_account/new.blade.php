
@extends('master_bpk')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Halaman Tambah Akun Pemeriksa BPK
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Form Tambah Akun Pemeriksa BPK</h3>
                </div>
                <form action="{{ url('tambah_akun') }}" method="post">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Pengguna</label>
                            <input type="text" class="form-control" name="username" placeholder="Masukan Nama Pengguna">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" class="form-control" id="exampleInputPassword1" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Provinsi</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="provinsi" disabled>
                                <option > - </option>
                                @foreach($provinsi as $val)
                                    <option value="{{ $val->id }}" @if($dataMaster->province_id== $val->id) selected @endif> {{ $val->province }} </option>
                                @endforeach
                            </select>
                            <input type="hidden" value="{{ $dataMaster->province_id }}" name="provinsi" readonly>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputPassword1">Kabupaten/Kota</label>
                            <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true"  name="kabupaten">
                                <option > - </option>
                                @foreach($kabupaten as $val)
                                    <option value="{{ $val->id }}"> {{ $val->district }} </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                <!-- /.box-body -->
                <div class="box-footer">
                    {{ csrf_field() }}
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

@section('jsContainer')
    <script>
        $(document).ready(function () {
            getKabupaten = function (id) {
                $.ajax({
                    url :"{{ url('getkabupaten') }}/"+id,
                    dataType: "json",
                    success: function (result) {
                        $val = "";
                        $.each(result, function (index, value) {
                            $val+="<option value='"+value.id+"'>"+ value.district +"</option>"
                        });
                        $('[name="kabupaten"]').html($val)
                    }
                })
            }

            getKabupaten("{{ $dataMaster->province_id }}")

        })
    </script>
@stop