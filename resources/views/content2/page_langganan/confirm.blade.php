
@extends('master2')
<!-- Content Wrapper. Contains page content -->

@section('content')

    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
           <section class="content-header">
                <h1>
                    Konfirmasi Pembayaran
                </h1>
            </section>


        <!-- Main content -->
        <section class="content">
            <div class="row">
            <!-- Default box -->
                <div class="col-md-12">
                    <!-- Horizontal Form -->
                    <div class="box box-info">
                        <div class="box-header with-border">
                            <h3 class="box-title">Konfirmasi untuk tagihan #{{ $data->id }}</h3>
                        </div>
                        <!-- /.box-header -->
                        <!-- form start -->
                        <form class="form-horizontal" method="post" action="{{ url('prosesConfirm/'.$data->id) }}" enctype="multipart/form-data">
                            <div class="box-body">
                                @if($errors->any())
                                    @foreach($errors as $error)
                                        <p style="color: red">{{ $error }}</p>
                                    @endforeach
                                @endif
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Bank Tujuan</label>

                                    <div class="col-sm-10">
                                        <select class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" name="bank_tujuan">
                                               <option value="243.01.04.000006-2">BPD Sultra No. Rek : 243.01.04.000006-2</option>
                                               <option value="8280001189">Bank Muamalat No. Rek : 8280001189</option>
                                        </select>

                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Bank Pengirim</label>
                                    <div class="col-sm-10">
                                        <input type="input" class="form-control" name="pengirim_bank" placeholder="Contoh: Bank BCA">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nomor Rekening Pengirim</label>
                                    <div class="col-sm-10">
                                        <input type="input" class="form-control" name="no_rek_pengirim" placeholder="1213123123 atau no seri transfer bank">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Nama Pengirim</label>
                                    <div class="col-sm-10">
                                        <input type="input" class="form-control" name="nama_pengirim" placeholder="Contoh: Fandi">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Tanggal Pengirim</label>
                                    <div class="col-sm-10">
                                        <input type="text" id="datepicker" class="form-control" name="tanggal_pengirim" data-inputmask="'alias': 'dd-mm-yyyy'" data-mask>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Jumlah Transfer</label>
                                    <div class="col-sm-10">
                                        @php($tax = ($data->get_periode->value * $data->get_harga->range)*0.1)
                                        <input type="input" class="form-control" name="nilai_transfer" value="{{ ($data->get_periode->value*$data->get_harga->range)+$tax }}" readonly>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Bukti Transfer</label>
                                    <div class="col-sm-10">
                                        <input type="file" name="image"> Format File .jpg, .png
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="inputEmail3" class="col-sm-2 control-label">Catatan</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" rows="3" name="catatan">Mohon di proses biaya perpanjangan sewa server hosting, pemeliharaan dan pengembangan aplikasi Persediaan Barang Pakai Habis Dinas: .................... Kab./Kota :.............................. Provinsi:..............................Untuk Jangan Waktu: ..................(Bulan/Tahun)...... Tahun Anggaran:............
                                        </textarea>
                                    </div>
                                </div>
                            </div>
                            <!-- /.box-body -->
                            <div class="box-footer">
                                <input type="hidden" name="_method" value="PUT">
                                {{ csrf_field() }}
                                <button type="submit" class="btn btn-info pull-right">Kirim</button>
                            </div>
                            <!-- /.box-footer -->
                        </form>
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
            $('#datepicker').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' })

            //Date picker
            $('#datepicker').datepicker({
                autoclose: true,
                format: 'dd-mm-yyyy'
            })
        });
    </script>
@stop