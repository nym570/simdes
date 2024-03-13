<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kedatangan;
use App\Models\Desa;
use App\Models\Warga;
use App\Models\Dinamika;
use App\Models\Ruta;
use App\Models\User;
use App\Models\AnggotaRuta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KedatanganDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Message;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Builder;

class KedatanganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KedatanganDataTable $dataTable)
    {
        $title = 'Kedatangan';
		 return $dataTable->render('menu.dinamika.kedatangan.index',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = 'Buat Data Kedatangan';
        return view('menu.dinamika.kedatangan.create',compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $desa = Desa::get()->first();
        if($request->file('bukti')){
            $extension = $request->file('bukti')->extension();
            $data['bukti'] = Storage::disk('public')->putFileAs('dinamika', $request->file('bukti'),date('Ymd').'_kedatangan_'.$data['kepala_nik'].'.'.$extension);
        }
        $pendatang = json_decode($data['pendatang']);
        $datang =[
            'waktu' => $data['waktu'],
            'bukti' => $data['bukti'],
            'keterangan' => $data['keterangan'],
            'is_new' => $data['is_new_ruta'],
            'kepala_nik' => $data['kepala_nik'],
        ];
        if($data['is_new_ruta']==true){
            $datang['is_new'] = 1;
            $datang['rt_id'] = auth()->user()->warga->rt_id;
            $datang['alamat_domisili'] = $data['alamat_domisili'];
            $datang['jumlah_art'] = count($pendatang);
        }
        else{
            $datang['is_new_ruta'] = 0;
        }
        
        $kedatangan = Kedatangan::create($datang);
        
        foreach($pendatang as $item){
            
            if($item->kode_wilayah_ktp==$desa['kode_wilayah']){
                $item->ktp_desa = 1;
            }
            else{
                $item->ktp_desa = 0;
            }
            $identitas = [
                'nik' => $item->nik,
                'no_kk' => $item->no_kk,
                'nama' => $item->nama,
                'tempat_lahir' =>  $item->tempat_lahir,
                'tanggal_lahir' =>  $item->tanggal_lahir,
                'jenis_kelamin' => $item->jenis_kelamin,
                'agama' => $item->agama,
                'gol_darah' =>$item->gol_darah,
                'kode_wilayah_ktp' => $item->kode_wilayah_ktp,
                'alamat_ktp' => $item->alamat_ktp,
                'pendidikan' => $item->pendidikan,
                'pekerjaan' => $item->pekerjaan,
                'no_telp' => $item->no_telp,
                'ktp_desa' => $item->ktp_desa,
                'status' => 'Pending',
                'rt_id' => auth()->user()->warga->rt_id,
            ];
            $warga = Warga::create($identitas);
            $kedatangan->dinamika()->create([ 'nik' => $identitas['nik'] ]);
        }
        $this->verifikasi($kedatangan);
        return redirect(route('dinamika.kedatangan.index'))->withSuccess('Data Kedatangan berhasil ditambahkan');
        
        //
    }
    public function verifikasi(Kedatangan $kedatangan){
        $count['jumlah_art'] = 0;
        $ruta = "";
        if($kedatangan->is_new){
            $validated= [
                'alamat_domisili' => $kedatangan->alamat_domisili,
                'rt_id' => $kedatangan->rt_id,
                'jumlah_art' => 0,
            ];
            
            $ruta = Ruta::create($validated);
            
        }
        else{
            $ruta = Ruta::where('id',$kedatangan->kepala_nik)->first();
            $count['jumlah_art'] = $ruta['jumlah_art'];
        }

        foreach($kedatangan->dinamika as $item){
            $warga = Warga::where('nik',$item->nik)->first();
            $count['jumlah_art']++;
            
            $warga->update(['status'=>'warga']);
            if($warga->nik == $kedatangan['kepala_nik']){
                $art= [
                    'anggota_nik' => $warga->nik,
                    'hubungan' => 'Kepala Keluarga',
                    'ruta_id' => $ruta->id,
                ];
                $anggota_ruta = AnggotaRuta::create($art);
            }
            else{
                $art= [
                    'anggota_nik' => $warga->nik,
                    'hubungan' => 'Lainnya',
                    'ruta_id' => $ruta->id,
                ];
                $anggota_ruta = AnggotaRuta::create($art);
            }
            
            
            
        }
        $ruta->update($count);
        $kedatangan->update(['verifikasi'=>true]);
        $hal ='Data Kedatangan diverifikasi';
        $kepala_ruta = User::whereHas("warga.anggota_ruta", function(Builder $builder) use($ruta) {
            $builder->where('ruta_id', '=', $ruta->id)->where('hubungan','Kepala Keluarga');
        })->first();
        if($kepala_ruta){
            $message = 'Data kedatangan untuk '.$count['jumlah_art'].' berhasil ditambahkan dan terdaftar sebagai warga anggota rumah tangga anda.';
            Notification::send($kepala_ruta, new Message('ketua RT',$hal,$message,route('login')));
        }
        return redirect()->route('ruta.show',$ruta)->withSuccess('Verifikasi kedatangan berhasil, Silahkan ubah silsilah rumah tangga');
    }

    // public function tolak(Request $request,Kedatangan $kedatangan){
    //     Storage::disk('public')->delete($kedatangan->bukti);
    //     foreach($kedatangan->dinamika as $item){
    //         $item->warga->delete();
    //     }
    //     $kedatangan->dinamika->delete();
    //     if(!$kedatangan->is_new){
    //         $hal ='Data Kedatangan ditolak';
    //         $kepala_ruta = User::whereHas("warga.anggota_ruta", function(Builder $builder) use($kelahiran) {
    //             $builder->where('ruta_id', '=', $kedatangan->kepala_nik)->where('hubungan','Kepala Keluarga');
    //         })->first();
    //         Notification::send($kepala_ruta, new Message('ketua RT',$hal,$request['message'],route('login')));
    //     }

    //     $kedatangan->delete();
        
    //     return back()->withSuccess('Data kedatangan ditolak');
    // }

    public function get(Kedatangan $kedatangan)
    {
        if($kedatangan->is_new){
            $kepala = Warga::where('nik',$kedatangan->kepala_nik)->first();
            $kedatangan['kepala_nik'] = $kepala->nik;
            $kedatangan['kepala_nama'] = $kepala->nama;
        }
        else{
            $kepala = Warga::whereHas("anggota_ruta", function(Builder $builder) use($kedatangan) {
                $builder->where('ruta_id', '=', $kedatangan->kepala_nik)->where('hubungan','Kepala Keluarga');
            })->first();
            $kedatangan['kepala_nik'] = $kepala->nik;
            $kedatangan['kepala_nama'] = $kepala->nama;
        }
		return json_encode($kedatangan);
    }

    public function pendatang(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nik' => ['required', 'string','unique:warga,nik','size:16'],
            'no_kk' => ['required', 'string','size:16'],
            'nama' => ['required', 'string'],
            'tempat_lahir' =>  ['required', 'string'],
            'tanggal_lahir' =>  ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'pendidikan' => ['required', 'string'],
            'pekerjaan' => ['required', 'string'],
            'agama' => ['required', 'string'],
            'gol_darah' => ['required', 'string'],
            'kode_wilayah_ktp' => ['required', 'string','regex:/[0-9]{2}.[0-9]{2}.[0-9]{4}/u'],
            'alamat_ktp' => ['required', 'string'],
             'no_telp' => ['required', 'string','regex:/62[0-9]+$/u'],
        ]);
        if ($validator->fails()) {
            return response()->json(['error'=>$validator->errors()->all()]);
        }
        return json_encode($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Kedatangan $kedatangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kedatangan $kedatangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kedatangan $kedatangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kedatangan $kedatangan)
    {
        //
    }
}
