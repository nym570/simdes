<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('assets/vendor/fonts/boxicons.css') }}" />
    <title>Bukti Permohonan Informasi</title>
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
            <font size="4"><b>FORMULIR PERMOHONAN INFORMASI</b></font><br>
            <hr style="margin:auto" color="black" width="370px">
            <span>No. Pendaftaran : {{$permohonan->no_pendaftaran}}</span>
        </center>
    </div>
    <br>
    <br>
    <div style="padding-left: 50px; margin:0px; padding-right: 50px;">
        <table border="0">
            <tr>
                <td>Nama / NIK</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->nama}} &nbsp; ({{$permohonan->nik_pengaju}})</td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->alamat}}</td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->pekerjaan}}</td>
            </tr>
            <tr>
                <td>Email / Telp</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->email}} &nbsp; (+{{$permohonan->no_telp}} )</td>
            </tr>
            <tr>
                <td>Rincian Informasi yang Dibutuhkan</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->rincian}}</td>
            </tr>
            <tr>
                <td>Tujuan Penggunanaan</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->tujuan}}</td>
            </tr>
            <tr>
                <td>Cara Perolehan</td>
                <td>:</td>
                <td>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->cara_perolehan,'melihat/membaca/mendengarkan/mencatat')?'-checked':''}}'></i> Melihat/Membaca/Mendengarkan/Mencatat</div>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->cara_perolehan,'mendapat salinan')?'-checked':''}}'></i> Mendapatkan Salinan Informasi</div>
                </td>
            </tr>
            <tr>
                <td>Media Perolehan</td>
                <td>:</td>
                <td>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->media_perolehan,'langsung')?'-checked':''}}'></i> Datang Langsung</div>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->media_perolehan,'kurir/pos')?'-checked':''}}'></i> Kurir / Pos </div>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->media_perolehan,'email/wa')?'-checked':''}}'></i> Email / Whatsapp </div>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->media_perolehan,'lainnya')?'-checked':''}}'></i> Lainnya </div>
                </td>
            </tr>
        </table>
        <br>
        <br>
        <br>
        <table border="0" align="center">
            <tr>
                <td>
                      {{$desa->sebutan}} {{$desa->desa}}, {{$permohonan->created_at}}
                </td>
            </tr>
        </table>
        <br>
        <table border="0" width="100%">
            <tr>
                <td style="text-align: center;"> Petugas Pelayanan Informasi </td>
                <td style="text-align: center;">Pemohon Informasi</td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                <td></td>
            </tr>
           
            <tr>
                <td ><hr style="margin:auto;" color="black" width="170px"></td>
                <td ><hr style="margin:auto;" color="black" width="170px"></td>
            </tr>
            <tr>
                <td style="text-align: center;" >PPID {{$desa->sebutan}} {{$desa->desa}}</td>
                <td style="text-align: center;" >{{$permohonan->nama}}</td>
            </tr>
        </table>
    </div>
    



    
</body>
</html>