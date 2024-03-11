<?php

namespace App\Http\Controllers\Pengajuan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Kelahiran;
use App\Models\Desa;
use App\Models\Dinamika;
use App\Models\Warga;
use App\Models\User;
use App\Models\Ruta;
use App\Models\AnggotaRuta;

class PengajuanDinamika extends Controller
{
    public function index()
    {

        $title = 'Layanan Kependudukan Warga';
		return view('menu.pengajuan.kependudukan.index',compact('title'));
    }
    public function kelahiran(Request $request){
        $data = $request->validate([
            'nik' => ['required','string','size:16'],
            'ibu_nik' => ['required','string','size:16'],
            'bapak_nik' => ['required','string','size:16'],
            'no_kk' => ['required', 'string','size:16'],
            'nama' => ['required', 'string'],
            'tempat_lahir' =>  ['required', 'string'],
            'jenis_kelamin' => ['required', 'string'],
            'agama' => ['required', 'string'],
            'berat' => ['required', 'numeric'],
            'panjang' => ['required', 'numeric'],
            'gol_darah' => ['required', 'string'],
            'hubungan_ruta' => ['required', 'string'],
            'kode_wilayah_ktp' => ['required', 'string','regex:/[0-9]{2}.[0-9]{2}.[0-9]{4}/u'],
            'alamat_ktp' => ['required', 'string'],
            'tempat' => ['required','string'],
            'keterangan' => ['string'],
            'waktu' => ['required','date','before_or_equal:today'],
            'bukti' => ['required','mimes:jpg,png,pdf','max:1024']
            
        ]);

        $data['tanggal_lahir']  = Carbon::parse(explode('T', $data['waktu'])[0]);
        $data['pendidikan'] = 'Tidak / Belum Sekolah';
        $data['pekerjaan'] = 'Belum/ Tidak Bekerja';
        $ruta = Ruta::whereHas("anggota_ruta", function(Builder $builder) {
            $builder->where('anggota_nik', '=', auth()->user()->nik);
        })->first();
        $data['ruta_id'] = $ruta->id;
        $data['tempat_lahir'] = Str::title($data['tempat_lahir']);
        $desa = Desa::get()->first();
        if($data['kode_wilayah_ktp']==$desa['kode_wilayah']){
            $data['ktp_desa'] = 1;
        }
        else{
            $data['ktp_desa'] = 0;
        }
        $data['status'] = 'Pending';
        if($request->file('bukti')){
            $extension = $request->file('bukti')->extension();
            $data['bukti'] = Storage::disk('public')->putFileAs('dinamika', $request->file('bukti'),date('Ymd').'_kelahiran_'.$data['nik'].'.'.$extension);
        }
        $identitas = [
            'nik' => $data['nik'],
            'no_kk' => $data['no_kk'],
            'nama' => $data['nama'],
            'tempat_lahir' =>  $data['tempat_lahir'],
            'tanggal_lahir' =>  $data['tanggal_lahir'],
            'jenis_kelamin' => $data['jenis_kelamin'],
            'agama' => $data['agama'],
            'gol_darah' =>$data['gol_darah'],
            'kode_wilayah_ktp' => $data['kode_wilayah_ktp'],
            'alamat_ktp' => $data['alamat_ktp'],
            'pendidikan' => $data['pendidikan'],
            'pekerjaan' => $data['pekerjaan'],
            'ktp_desa' => $data['ktp_desa'],
            'status' => $data['status'],
            'rt_id' => auth()->user()->warga->rt_id,
        ];
        $lahir = [
            'ibu_nik' => $data['ibu_nik'],
            'bapak_nik' => $data['bapak_nik'],
            'ruta_id' => $data['ruta_id'],
            'hubungan_ruta' => $data['hubungan_ruta'],
            'berat' => $data['berat'],
            'panjang' => $data['panjang'],
            'keterangan' => $data['keterangan'],
            'waktu' => $data['waktu'],
            'tempat' => $data['tempat'],
            'bukti' => $data['bukti'],
        ];
        
       
        $warga = Warga::create($identitas);

       
        
        
        $kelahiran = Kelahiran::create($lahir);
        $kelahiran->dinamika()->create([ 'nik' => $data['nik'] ]);
        
        return back()->withSuccess('Data Kelahiran berhasil ditambahkan');
    }
}
