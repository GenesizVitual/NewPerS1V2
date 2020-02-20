<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<div class="container" style="margin-top: 10px">
    <div class="row">
        <div class="col-sm-12">
            <form action="{{ url('import-to-persediaan') }}" method="post">
                {{ csrf_field() }}
                <h1>Daftar Program rekening    <button class="btn btn-primary" type="submit" onclick="return confirm('Apakah Anda Akan Melakukan Import Data...?')"> Import  </button>
                </h1>
            <div class="row">
                <ul class="list-group" style="width: 100%">
                        @foreach($data_prog as $no_program => $data)
                            @php($query_kegiatan = $data_belanja->where('Kd_Bidang','1')->where('Kd_Prog',$data->Kd_Prog)->where('Kd_Unit','1')->where('Kd_Rek_1','5')->where('Kd_Rek_2','2')->where('Kd_Rek_3','2')->whereIn('Kd_Rek_4', ['1','6'])->groupBy('Kd_Keg')->get() )
                                @if($query_kegiatan->count()!=0)

                                    <li class="list-group-item">
                                        <p style="font-weight: bold">
                                            {{ $query_kegiatan[0]->Kd_Urusan }}.{{ FormatRekening::kodeRekening($query_kegiatan[0]->Kd_Bidang)  }}.{{ FormatRekening::kodeRekening($query_kegiatan[0]->Kd_Sub)  }}.{{ FormatRekening::kodeRekening($query_kegiatan[0]->Kd_Prog) }} {{ $data->Ket_Program }}
                                            <input type="hidden" name="kode_rekening[]" value="{{ $query_kegiatan[0]->Kd_Urusan }}.{{ FormatRekening::kodeRekening($query_kegiatan[0]->Kd_Bidang)  }}.{{ FormatRekening::kodeRekening($query_kegiatan[0]->Kd_Sub)  }}.{{ FormatRekening::kodeRekening($query_kegiatan[0]->Kd_Prog) }}">
                                            <input type="hidden" name="nama_program[]" value="{{ $data->Ket_Program }}">
                                            <input type="hidden" name="tahun_anggaran" value="{{$query_kegiatan[0]->Tahun}}">

                                        </p>
                                    </li>
                                    @foreach( $query_kegiatan as $data_keg)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            @php($kd_kegs =$data_keg->Kd_Keg )
                                            @php($keterangan_data=$data_kegiatan->where('Kd_Urusan','1')->where('Kd_Bidang',$data_keg->Kd_Bidang)->where('Kd_Prog',$data_keg->Kd_Prog)->where('Kd_Keg', $kd_kegs)->first())
                                            @if(!empty($keterangan_data))
                                                <a href="{{ url('belanja/'.$keterangan_data->Kd_Urusan.'/'.$data_keg->Kd_Unit.'/'.$keterangan_data->Kd_Bidang.'/'.$keterangan_data->Kd_Prog.'/'.$data_keg->Kd_Keg.'/'.$data_keg->Kd_Rek_1.'/'.$data_keg->Kd_Rek_2.'/'.
                                                $data_keg->Kd_Rek_3.'/'.$data_keg->Kd_Rek_4.'/'.$data_keg->Kd_Rek_5) }}">
                                                        {{ $keterangan_data->Kd_Urusan }} {{ $data_keg->Kd_Unit }} {{ $keterangan_data->Kd_Bidang }} {{ $keterangan_data->Kd_Prog }} {{ $keterangan_data->Kd_Keg }} {{ $data_keg->Kd_Rek_1 }}
                                                        {{ $data_keg->Kd_Rek_2 }} {{ $data_keg->Kd_Rek_3 }} {{ $data_keg->Kd_Rek_4 }} {{ $data_keg->Kd_Rek_5 }} {{$keterangan_data->Ket_Kegiatan}}

                                                    <input type="hidden" name="kode_kegiatan_belanja_{{$no_program}}[]" value="{{ $keterangan_data->Kd_Urusan }}.{{ $data_keg->Kd_Unit }}.{{ $keterangan_data->Kd_Bidang }}.{{ $keterangan_data->Kd_Prog }}.{{ $keterangan_data->Kd_Keg }}.{{ $data_keg->Kd_Rek_1 }}.{{ $data_keg->Kd_Rek_2 }}.{{ $data_keg->Kd_Rek_3 }}.{{ $data_keg->Kd_Rek_4 }}.{{ $data_keg->Kd_Rek_5 }}">
                                                    <input type="hidden" name="kode_kegiatan_uniqe_{{$no_program}}[]" value="{{ $keterangan_data->Kd_Keg }}.{{ $data_keg->Kd_Rek_1 }}.{{ $data_keg->Kd_Rek_2 }}.{{ $data_keg->Kd_Rek_3 }}.{{ FormatRekening::kodeRekening($data_keg->Kd_Rek_4) }}.{{ FormatRekening::kodeRekening($data_keg->Kd_Rek_5)  }}">
                                                    <input type="hidden" name="kode_kegiatan_{{$no_program}}[]" value="{{ $data_keg->Kd_Rek_1 }}.{{ $data_keg->Kd_Rek_2 }}.{{ $data_keg->Kd_Rek_3 }}.{{ FormatRekening::kodeRekening($data_keg->Kd_Rek_4) }}.{{ FormatRekening::kodeRekening($data_keg->Kd_Rek_5)  }}">

                                                    <input type="hidden" name="nama_kegiatan_{{$no_program}}[]" value="{{$keterangan_data->Ket_Kegiatan}}">

                                                </a>
                                                @else

                                            @endif

                                            <span class="badge badge-primary badge-pill"></span>
                                        </li>
                                    @endforeach
                                @endif
                        @endforeach

                </ul>
            </div>
            </form>
        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>