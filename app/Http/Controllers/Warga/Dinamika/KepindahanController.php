<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kepindahan;
use App\Models\Warga;
use App\Models\Ruta;
use App\Models\User;
use App\Models\AnggotaRuta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KepindahanDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Helper\wilayahHelper;
use Illuminate\Database\Eloquent\Builder;
use App\Notifications\Message;
use Illuminate\Support\Facades\Notification;

class KepindahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KepindahanDataTable $dataTable)
    {
        $title = 'Kepindahan';
		 return $dataTable->render('menu.dinamika.kepindahan.index',compact('title'));
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
            'nik' => ['required'],
			'alamat_pindah' => ['required','string'],
            'waktu' => ['required','date'],
            'penyebab' => ['required','string'],
            'jenis' => ['required','string'],
            'kode_wilayah_pindah' => ['required','string','size:13'],
            'bukti' => ['mimes:jpg,png,pdf','max:1024'],
            'keterangan' =>[]
		]);
        
        if($request->file('bukti')){
            $extension = $request->file('bukti')->extension();
            $data['bukti'] = Storage::disk('public')->putFileAs('dinamika', $request->file('bukti'),date('Ymd').'_kepindahan_'.$data['nik'][0].'.'.$extension);
        }
        $kepindahan = Kepindahan::create($data);
       
        foreach($data['nik'] as $item){
            $kepindahan->dinamika()->create([ 'nik' => $item ]);
        }
        $this->verifikasi($kepindahan);
        return back()->withSuccess('Data Kepindahan berhasil ditambahkan');
    }
    public function get(Kepindahan $kepindahan)
    { 
        $wilayah = array();
        $wilayah = explode('.',$kepindahan->kode_wilayah_pindah);
        $kepindahan['nama_wil_pindah'] = wilayahHelper::getNamaDes($kepindahan->kode_wilayah_pindah).', '. wilayahHelper::getNamaKec($wilayah[0].'.'.$wilayah[1].'.'.$wilayah[2]).', '. wilayahHelper::getNamaKab($wilayah[0].'.'.$wilayah[1]).', '.wilayahHelper::getNamaProv($wilayah[0]);
		return json_encode($kepindahan);
    }

    public function verifikasi(Kepindahan $kepindahan){
        foreach($kepindahan->dinamika as $item){
            $warga = Warga::where('nik',$item->nik)->with('anggota_ruta.ruta')->first();
            $ruta = $warga->anggota_ruta->ruta;
            $warga->update(['status'=>'pindah']);
            $user = User::where('nik',$warga->nik)->first();
            if($user){
                $user->update(['is_active'=>0]);
            }
            
            


            if($warga->has('anggota_ruta')){
                $temp['jumlah_art'] = $warga->anggota_ruta->ruta->jumlah_art - 1;
                $warga->anggota_ruta->delete();
                
                if($temp['jumlah_art'] == 0){
                    $ruta->delete();
                }
                else{
                    $warga->anggota_ruta->ruta->update($temp);
                    if($warga->anggota_ruta->hubungan =='Kepala Keluarga'){
                        $lain = AnggotaRuta::where('ruta_id',$warga->anggota_ruta->ruta->id)->where('anggota_nik','!=',$warga->nik)->orderBy('hubungan')->first();
                        $lain->update(['hubungan'=>'Kepala Keluarga']);
                    }
                    // $hal ='Data Kepindahan diverifikasi';
                    // $kepala_ruta = User::whereHas("warga.anggota_ruta", function(Builder $builder) use($warga) {
                    //     $builder->where('ruta_id', '=', $warga->anggota_ruta->ruta_id)->where('hubungan','Kepala Keluarga');
                    // })->first();
                    // if($kepala_ruta){
                    //     $message = 'Data kepindahan diverifikasi untuk anggota rumah tangga anda '.$warga->nama.'['.$warga->nik.']. Warga dihapus dari rumah tangga anda';
                    //     Notification::send($kepala_ruta, new Message('ketua RT',$hal,$message,route('login')));
                    // }
                }
            

        }
        }
        $kepindahan->update(['verifikasi'=>true]);
        return back()->withSuccess('Verifikasi berhasil');
    }

    public function tolak(Request $request,Kepindahan $kepindahan){
        foreach($kepindahan->dinamika as $item){
            $warga = Warga::with('anggota_ruta')->where('nik',$item->nik)->first();
            $item->delete();
            if($warga->has('anggota_ruta')){
                $hal ='Data Kepindahan ditolak';
                $kepala_ruta = User::whereHas("warga.anggota_ruta", function(Builder $builder) use($warga) {
                    $builder->where('ruta_id', '=', $warga->anggota_ruta->ruta_id)->where('hubungan','Kepala Keluarga');
                })->first();
                if($kepala_ruta){
                    $request['message'] = 'Data kepindahan ditolak untuk anggota rumah tangga anda '.$warga->nama.'['.$warga->nik.'].'.$request['message'];
                    Notification::send($kepala_ruta, new Message('ketua RT',$hal,$request['message'],route('login')));
                }
            
            }
            

            
        }
        Storage::disk('public')->delete($kepindahan->bukti);
        $kepindahan->delete();
        return back()->withSuccess('Data kepindahan ditolak');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kepindahan $kepindahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kepindahan $kepindahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kepindahan $kepindahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kepindahan $kepindahan)
    {
        //
    }
}
