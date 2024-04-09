<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ public_path('assets/vendor/fonts/boxicons.css') }}" />
    <title>Surat Keterangan Penolakan PPID</title>
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
            padding-bottom : 5px;
            text-align: justify;
        }
        p.solid {border-style: solid; margin-top: 0px; }
        </style>
</head>
<body>

    <table border="0" align="center" width="100%" style="padding-left: 50px; padding-right: 50px;">
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
        <td><img src="{{ public_path('assets/img/icons/logo.png') }}" width="85" height="85" alt=""></td>
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
													<font size="3">PEMERINTAHAN {{strtoupper($desa->kabupaten)}}</font><br>
                                                    <font size="3">KECAMATAN {{strtoupper($desa->kecamatan)}}</font><br>
                                                    <font size="4"><b>{{strtoupper($desa->sebutan)}} {{strtoupper($desa->desa)}}</b></font><br>
                                                    <font size="1"><i>{{$desa->alamat_kantor}}</i></font><br>
                                                    <font size="1"><i>Telp : {{$desa->no_telp}} Email : {{$desa->email_desa}}</i></font><br>
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
            <font size="3"><b>SURAT KEPUTUSAN PPID TENTANG PENOLAKAN PERMOHONAN</b></font><br>
            <hr style="margin:auto" color="black" width="500px">
        </center>
    </div>
    <br>
    <br>
    <div style="padding-left: 50px; margin:0px; padding-right: 50px;">
        <table border="0">
            <tr style="padding: 0px; margin:0">
                <td>No Pendaftaran</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->no_pendaftaran}}</td>
            </tr>
            <tr style="padding: 0px; margin:0">
                <td>Nama / NIK</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->nama}} &nbsp; ({{$permohonan->nik_pengaju}})</td>
            </tr>
            <tr style="padding: 0px; margin:0">
                <td>Alamat</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->alamat}}</td>
            </tr>
            <tr style="padding: 0px; margin:0">
                <td>Email / Telp</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->email}} &nbsp; (+{{$permohonan->no_telp}} )</td>
            </tr>
            <tr style="padding: 0px; margin:0">
                <td>Rincian Informasi yang Dibutuhkan</td>
                <td>&nbsp;:&nbsp;</td>
                <td>{{$permohonan->rincian}}</td>
            </tr>
        </table>
        
            <p><strong>PPID memutuskan bahwa informasi yang dimohon adalah :</strong></p>
                    <center>
                        <p class="solid"><strong>INFORMASI YANG DIKECUALIKAN</strong></p>
                    </center>
                
        <table border="0">
            <tr>
                <td width="200px">Pengecualian Informasi didasarkan pada alasan</td>
                <td>:</td>
                <td>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->penolakan,'a')||str_contains($permohonan->penolakan,'b')||str_contains($permohonan->penolakan,'c')||str_contains($permohonan->penolakan,'d')||str_contains($permohonan->penolakan,'e')||
                    str_contains($permohonan->penolakan,'f')||str_contains($permohonan->penolakan,'g')||str_contains($permohonan->penolakan,'h')||str_contains($permohonan->penolakan,'i')||str_contains($permohonan->penolakan,'j')?'-checked':''}}'></i> Pasal 17 huruf &nbsp; {{str_replace('lain,','',$permohonan->penolakan)}} &nbsp; UU KIP</div>
                    <div><i class='bx bx-checkbox{{str_contains($permohonan->penolakan,'lain')?'-checked':''}}'></i> Undang-Undang Lainnya</div>
                    
                </td>
            </tr>
        </table>
        <p>Bahwa berdasarkan pasal-pasal di atas, membuka informasi tersebut dapat menimbulkan konsekuensi sebagai berikut : </p>
        <p style="text-align: justify;">{{$permohonan->keterangan}}</p>
        <p><strong>Dengan demikian menyatakan bahwa :</strong></p>
        <center>
            <p class="solid"><strong>PERMOHONAN INFORMASI DITOLAK</strong></p>
        </center>
        <p style="text-align: justify;">Jika pemohon informasi keberatan atas penolakan ini, maka Pemohon dapat mengajukan keberatan kepada PPID selambat-lambatnya 30 (tiga puluh) hari sejak menerima Surat Keputusan ini</p>
        <br>
        <table border="0">
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                      {{$desa->sebutan}} {{$desa->desa}}, {{$permohonan->waktu}}
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                      Pejabat Pengelola Informasi dan Dokumentasi (PPID)
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                    <hr style="margin-left:0; margin-bottom:0" color="black" width="200px">
                </td>
            </tr>
            <tr>
                <td width="175px"></td>
                <td width="175px"></td>
                <td>
                     {{auth()->user()->warga->nama}}
                </td>
            </tr>
        </table>
        
    </div>
    



    
</body>
</html>