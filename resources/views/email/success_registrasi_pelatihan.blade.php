<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <!-- Optional theme -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">

    <!-- Latest compiled and minified JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
    <title>Informasi Aplikasi Persediaan.id</title>
    <style>

        #button_confirm {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
<h3>
    Selamat, <br> Anda Telah Terdaftar Sebagai Peserta Pelatihan Persediaan.id<br>
    Nomor Registrasi: {{ $posts['Kode_registrasi'] }}

</h3>
<div style="padding-left: 2%">
    <p>Bimtek yang anda ikuti akan dilaksanakan pada:</p>
    <table style="margin-left: 4%;  width: 100%">
        <tr>
            <td style="width: 5%">Bulan</td>
            <td style="width: 1%">:</td>
            <td style="width: 100%">{{ $posts['bulan'] }}</td>
        </tr>
        <tr>
            <td>Tanggal</td>
            <td>:</td>
            <td>{{ date('d-m-Y', strtotime($posts['tanggal'])) }}</td>
        </tr>
        <tr>
            <td>Tempat</td>
            <td>:</td>
            <td>{{ $posts['tempat'] }}</td>
        </tr>
    </table>
    <p>Rincian Biaya</p>
    <table style="margin-left: 4%; width: 100%">
        <tr>
            <td style="width: 7%">Biaya Bimtek</td>
            <td style="width: 1%">:</td>
            <td style="width: 100%">{{ number_format($posts['biaya'],2,',','.') }} (Sudah Termasuk Pajak 10%)</td>
        </tr>
        @if(!empty($posts['kode_kupon']))
        <tr>
            <td>Bonus</td>
            <td>:</td>
            <td>

                {!!  $posts['kode_kupon']->bonus_peserta  !!}

            </td>
        </tr>
        @endif
    </table>
    <p>Silahkan Transfer Pembayaran Ke:</p>
    <table style="margin-left: 4%; width: 100%">
        <tr>
            <td style="width: 7%">Nama Bank</td>
            <td style="width: 1%">:</td>
            <td style="width: 100%">Bank Muamalat</td>
        </tr>
        <tr>
            <td>No. Rek</td>
            <td>:</td>
            <td>8280001189</td>
        </tr>
        <tr>
            <td>Atas Nama</td>
            <td>:</td>
            <td>Sumber Info Media, CV</td>
        </tr>
    </table>
    <p>Cashback berlaku jika pembayaran maksimal tanggal {{ date('d-m-Y', strtotime($posts['early_date'])) }}</p>
</div>
<p>
    <a href="{{ url('konfirmasi_pelatihan/'.$posts['Kode_registrasi']) }}" id="button_confirm">Konfirmasi Pembayaran</a>
</p>
</body>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
<script >
    $(document).ready(function () {

    })
</script>
</html>