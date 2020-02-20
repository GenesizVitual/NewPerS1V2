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
            <h1>Daftar Belanja</h1>
            <div class="row">
                <ul class="list-group" style="width: 100%">
                    @foreach($data_belanja as $data)
                        @php($belanja_sub = $data_belanja_sub_rinc->where('Kd_Rek_1',$data->Kd_Rek_1)
                                ->where('Kd_Rek_2',$data->Kd_Rek_2)
                                ->where('Kd_Rek_3',$data->Kd_Rek_3)
                                ->where('Kd_Rek_4',$data->Kd_Rek_4)
                                ->where('Kd_Rek_5',$data->Kd_Rek_5)->first())
                        <li class="list-group-item">
                            <p style="font-weight: bold">
                                {{ $data->Kd_Rek_1 }} {{ $data->Kd_Rek_2 }} {{ $data->Kd_Rek_3 }} {{ $data->Kd_Rek_4 }} {{ $data->Kd_Rek_5 }} {{ $data->Keterangan }}
                                <button class="btn btn-primary pull-left">{{ $belanja_sub->Jml_Satuan }}</button>
                                <button class="btn btn-warning pull-left">{{ $belanja_sub->Satuan123 }}</button>
                                <button class="btn btn-danger pull-left">{{ number_format($belanja_sub->Nilai_Rp,2,',','.') }}</button>
                                <button class="btn btn-dark pull-left">{{ number_format($belanja_sub->Total,2,',','.') }}</button>
                            </p>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
    </div>
</div>
</body>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</html>