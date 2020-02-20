
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="col-md-12" style="padding-bottom: 1%">
            <section class="content-header">
                <h1>
                    Halaman DPA
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
                        <h3 class="box-title">Tabel DPA</h3>
                        <div class="box-tools pull-right">

                        </div>
                    </div>
                    <div class="box-body">
                        @if(Session::has('message_fail'))
                            <p style="color: red">{{ Session::get('message_fail') }} </p>
                        @endif
                        <div class="table-responsive">
                            <a href="{{ url('createDpa') }}" data-toggle="tooltip" title="Tambah Pagu Anggaran" class="mb-xs mt-xs mr-xs btn btn-primary"> Tambah DPA Anggaran </a>
                            <table class="table mb-none">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Tahun</th>
                                    <th>Jumlah Pagu</th>
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i=1)
                                    @foreach($data as $data)
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $data->get_thnAnggaran->years }}</td>
                                            <td>{{ number_format($data->pagu_value,0,'.','.') }}</td>
                                            <td>
                                                <form action="{{ url('deleteDpa/'.$data->id.'/delete') }}" method="post">
                                                    <a href="{{ url('editDpa/'.$data->id.'/edit') }}" type="button" class="mb-xs  btn btn-warning">ubah</a>
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="_method" value="put">
                                                    <button type="submit" class="mb-xs  btn btn-danger" onclick="return confirm('Apakah anda yakin akan menghapus data ini...?')">delete</button>
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