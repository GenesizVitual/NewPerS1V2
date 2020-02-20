
@extends('master_inspektorat_pemkot')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                Daftar Hak Akses Pemeriksa Inspektorat Pemkot
            </h1>
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="box">
                <div class="box-header with-border">
                    <h3 class="box-title">Daftar Hak Akses Pemeriksa Inspektorat Pemkot</h3>
                </div>
                <div class="box-body">

                    <div class="table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                            <tr>
                                <th>#</th>
                                <th>Instansi</th>
                                <th>Tingkat</th>
                                <th>Pilih</th>

                            </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- /.box-body -->
                <div class="box-footer">
                </div>
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
        $(document).ready(function(){


            $('#example1').DataTable({
              "ajax" : {
                  "url" : "{{ url('hakAksesInpektoratPemkot') }}/"+ '{{  $data->id }}',
                  "dataType" : "JSON"
              }
            });
            checkUncheck=function(element, id)
            {
                if(element.checked == true)
                {
                    $.ajax({
                       url  : '{{ url('tambah_hak_akses_inspektorat_pemkot') }}/'+ '{{ $data->id }}',
                       type : 'post',
                       data : {
                           '_method' : 'put',
                           '_token'  : '{{ csrf_token() }}',
                           'instansi': id
                       },
                       success: function(result){
                           console.log(result);
                       }
                    });
                }else if(element.checked == false){
                    $.ajax({
                        url  : '{{ url('hapus_hak_akses_inspektorat_pemkot') }}/'+ '{{ $data->id }}',
                        type : 'post',
                        data : {
                            '_method' : 'put',
                            '_token'  : '{{ csrf_token() }}',
                            'instansi': id
                        },
                        success: function(result){
                            console.log(result);
                        }
                    });
                }
            }
        });
    </script>
@stop