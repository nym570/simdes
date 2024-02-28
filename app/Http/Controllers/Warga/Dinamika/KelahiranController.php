<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kelahiran;
use App\Models\Desa;
use App\Models\Dinamika;
use App\Models\Warga;
use App\Models\AnggotaRuta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KelahiranDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

class KelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KelahiranDataTable $dataTable)
    {
        $title = 'Kelahiran';
		 return $dataTable->render('menu.dinamika.kelahiran.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      
        $data = $request->validate([
			'nik' => ['required','string','size:16'],
            'ibu_nik' => ['required','string','size:16'],
            'bapak_nik' => ['required','string','size:16'],
            'kepala_nik' => ['required','string','size:16'],
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
        $data['no_telp'] = '62753825483589';
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
            'no_telp' => $data['no_telp'],
            'ktp_desa' => $data['ktp_desa'],
            'status' => $data['status'],
        ];
        $lahir = [
            'ibu_nik' => $data['ibu_nik'],
            'bapak_nik' => $data['bapak_nik'],
            'kepala_nik' => $data['kepala_nik'],
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
    public function verifikasi(Kelahiran $kelahiran){
        $warga = Warga::where('nik',$kelahiran->dinamika->nik)->first();
        $kepala_ruta = AnggotaRuta::where('anggota_nik',$kelahiran->kepala_nik)->with('ruta')->first();
        $kelahiran->update(['verifikasi'=>true]);
        $warga->update(['status'=>'warga']);
        if($kepala_ruta){
            $temp['jumlah_art'] = $kepala_ruta->ruta->jumlah_art + 1;
            $anggota = [
                'anggota_nik' => $warga->nik,
                'hubungan' => $kelahiran->hubungan_ruta,
                'ruta_id' => $kepala_ruta->ruta_id,
            ];
        $anggota_ruta = AnggotaRuta::create($anggota);
        $kepala_ruta->ruta->update($temp);
        }
        return back()->withSuccess('Verifikasi berhasil');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kelahiran $kelahiran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelahiran $kelahiran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelahiran $kelahiran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelahiran $kelahiran)
    {
        //
    }
}
