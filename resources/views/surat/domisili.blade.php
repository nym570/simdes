<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('assets/vendor/fonts/boxicons.css') }}" />
    <title>Surat Keterangan Domisili</title>
    <style>
        body {
            width: 20cm;
        height: 29cm;
            /* to centre page on screen*/
            margin-left: auto;
            margin-right: auto;
        }
        table td {
            vertical-align: top;
            padding-bottom : 10px;
            text-align: justify;
        }
        </style>
</head>
<body>

    
<table border="0" align="center" width="100%" style="padding-left: 50px; padding-right: 50px; padding-top: 20px;">
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr></tr>
        <tr>
            <td></td>
        <td></td>
        <td></td>
        <td><br><img src="{{ public_path('assets/img/icons/logo.png') }}" width="85" height="85" alt=""></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
            <td>
                <center>
													<font size="4">PEMERINTAHAN {{strtoupper($desa->kabupaten)}}</font><br>
                                                    <font size="4">KECAMATAN {{strtoupper($desa->kecamatan)}}</font><br>
                                                    <font size="5"><b>{{strtoupper($desa->sebutan)}} {{strtoupper($desa->desa)}}</b></font><br>
                                                    <font size="2"><i>{{$desa->alamat_kantor}}</i></font><br>
                                                    <font size="2"><i>Telp : {{$desa->no_telp}} Email : {{$desa->email_desa}}</i></font><br>
                </center>
            </td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        </tr>
        <tr>
            <td colspan="45"><hr color="black"></td>
        </tr>
    </table>
    <br>
    <div>
        <center>
            <font size="4"><b>SURAT KETERANGAN DOMISILI</b></font><br>
            <hr style="margin:auto" color="black" width="300px">
            <span>Nomor : {{$temp['no']}}</span>
        </center>
    </div>
    <br>
    <br>
    <div style="padding-left: 50px; margin:0px; padding-right: 50px;">
        <p style="text-align: justify;">Yang bertanda tangan dibawah ini Kepala {{$desa->sebutan}} {{$desa->desa}} {{$desa->kecamatan}} {{$desa->kabupaten}}  menerangkan dengan sebenarnya bahwa : </p>
        <br>
        <table border="0">
            <tr>
                <td>Nama</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$suratKeterangan->warga->nama}}</td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$suratKeterangan->warga->nik}}</td>
            </tr>
            <tr>
                <td>Tempat, Tanggal Lahir</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$suratKeterangan->warga->tempat_lahir}}, {{$suratKeterangan->warga->tanggal_lahir}}</td>
            </tr>
            <tr>
                <td>Warga Negara / Agama</td>
                <td>&nbsp;:&nbsp;</td>
                <td>WNI / {{$suratKeterangan->warga->agama}}</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$suratKeterangan->warga->alamat_ktp}}</td>
            </tr>
           
            
        </table>
        <br>
        <p style="text-align: justify;">Adalah benar yang bersangkutan berdomisili di <strong>{{$temp['alamat']}} {{$suratKeterangan->domisili}} {{$desa->sebutan}} {{$desa->desa}} {{$desa->kecamatan}} {{$desa->kabupaten}}</strong>. Surat keterangan ini dibuat sebagai kelengkapan untuk <strong>{{$suratKeterangan->keperluan}}</strong>. </p>
        <p style="text-align: justify;">Demikian surat keterangan ini kami buat, untuk dapat digunakan sebagai mana mestinya. </p>
        <br>
        <br>
        <table border="0">
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                      {{$desa->kabupaten}}, {{$temp['waktu']}}
                </td>
            </tr>
            <tr>
                <td width="250px">
                    Pemohon
                </td>
                <td width="110px"></td>
                <td>
                      Kepala {{$desa->sebutan}} {{$desa->desa}} 
                </td>
            </tr>
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="250px"></td>
                <td width="110px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="250px">
                    <hr style="margin-left:0; margin-bottom:0" color="black" width="200px">
                </td>
                <td width="110px"></td>
                <td>
                    <hr style="margin-left:0; margin-bottom:0" color="black" width="200px">
                </td>
            </tr>
            <tr>
                <td width="250px">
                    {{$suratKeterangan->warga->nama}}
                </td>
                <td width="110px"></td>
                <td>
                     {{auth()->user()->warga->nama}}
                </td>
            </tr>
        </table>
    </div>
    



    
</body>
</html>