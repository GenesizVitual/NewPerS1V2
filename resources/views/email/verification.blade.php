<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<h3>
    Selamat {{$post->name}}, anda telah berhasil melakukan registrasi akun di persediaan.id
</h3>

<h3>untuk mengaktifkan akun anda, silahkan link berikut <a href="{{ url('verifikasi/'.$post->remember_token) }}">Verifikasi</a></h3>
    <br>
    <br>

<table>
    <tr>
        <td colspan="2" style="border-color: transparent;height: "><b>Best Regard's</b></td>
    </tr>
    <tr>
        <td colspan="2" style="border-color: transparent;">Inge</td>
    </tr>
    <tr>
        <td colspan="2" style="border-color: transparent;">Costomer Service Persediaan.id</td>
    </tr>
    <tr>
        <td colspan="2" style="border-color: transparent;">www.persediaan.id</td>
    </tr>
    <tr>
        <td style="border-color: transparent;">Head Office </td>
        <td style="border-color: transparent;">Jl. Pangeran Antasari No. 3 Kendari, Sultra</td>
    </tr>
    <tr>
        <td style="border-color: transparent;">Representation Office  </td>
        <td style="border-color: transparent;">Jl. Podocarpus I Senolowo, Sinduadi, Mlati, Sleman, Yogyakarta</td>
    </tr>
    <tr>
        <td style="border-color: transparent;">Call center </td>
        <td style="border-color: transparent;">0401-3083049</td>
    </tr>
    <tr>
        <td style="border-color: transparent;">WA / Telegram</td>
        <td style="border-color: transparent;">085228006675</td>
    </tr>
    <tr>
        <td style="border-color: transparent;">Fans Pages  </td>
        <td style="border-color: transparent;">@persediaan.id</td>
    </tr>
    <tr>
        <td style="border-color: transparent;">Group FB  </td>
        <td style="border-color: transparent;">Group Persediaa.id</td>
    </tr>
</table>

</body>
</html>