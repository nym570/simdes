<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kematian;
use App\Models\Warga;
use App\Models\Ruta;
use App\Models\User;
use App\Models\AnggotaRuta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KematianDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Notifications\Message;
use Illuminate\Support\Facades\Notification;
use Illuminate\Database\Eloquent\Builder;
use Jenssegers\Date\Date;

class KematianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KematianDataTable $dataTable)
    {
        $title = 'Kematian';
		 return $dataTable->render('menu.dinamika.kematian.index',compact('title'));
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
			'tempat' => ['required','string'],
            'waktu' => ['required','date','before_or_equal:today'],
            'penyebab' => ['required','string'],
            'saksi' => ['required','string'],
            'pelapor_nik' => ['required','string','size:16'],
            'bukti' => ['required','mimes:jpg,png,pdf','max:1024']
            
		]);
        
        $warga = Warga::where('nik',$data['nik'])->with('anggota_ruta')->first();
        $formatted_dt1=Date::createFromFormat('d M Y', $warga['tanggal_lahir']);
        $formatted_dt2=Date::parse($data['waktu']);
        $data['usia'] =  $formatted_dt1->diffInYears($formatted_dt2);
        if($request->file('bukti')){
            $extension = $request->file('bukti')->extension();
            $data['bukti'] = Storage::disk('public')->putFileAs('dinamika', $request->file('bukti'),date('Ymd').'_kematian_'.$data['nik'].'.'.$extension);
        }
        
        
        $kematian = Kematian::create($data);
        $kematian->dinamika()->create([ 'nik' => $data['nik'] ]);

        $this->verifikasi($kematian);
       
        
        return back()->withSuccess('Data Kematian berhasil ditambahkan');
    }
    public function verifikasi(Kematian $kematian){
        $warga = Warga::where('nik',$kematian->dinamika->nik)->with('anggota_ruta')->first();
        $kematian->update(['verifikasi'=>true]);
        $warga->update(['status'=>'meninggal']);
        if(!is_null($warga->anggota_ruta)){
            $ruta = Ruta::where('id',$warga->anggota_ruta->ruta_id)->first();
            $temp['jumlah_art'] = $ruta['jumlah_art'] - 1;
            
            if($temp['jumlah_art'] == 0){
                $ruta->delete();
            }
            else{
                $ruta->update($temp);
                if($warga->anggota_ruta->hubungan =='Kepala Keluarga'){
                    $lain = AnggotaRuta::where('ruta_id',$ruta->id)->where('anggota_nik','!=',$warga->nik)->orderBy('hubungan')->first();
                    $lain->update(['hubungan'=>'Kepala Keluarga']);
                }
                $hal ='Data Kematian diverifikasi';
                $kepala_ruta = User::whereHas("warga.anggota_ruta", function(Builder $builder) use($warga) {
                    $builder->where('ruta_id', '=', $warga->anggota_ruta->ruta_id)->where('hubungan','Kepala Keluarga');
                })->first();
                if($kepala_ruta){
                    $message = 'Data kematian diverifikasi untuk anggota rumah tangga anda '.$warga->nama.'['.$warga->nik.']. Warga dihapus dari rumah tangga anda';
                    Notification::send($kepala_ruta, new Message('ketua RT',$hal,$message,route('login')));
                }
            }
            $warga->anggota_ruta->delete();
            return redirect()->route('ruta.show',$ruta)->withSuccess('Verifikasi berhasil, Silahkan ubah silsilah rumah tangga');
            
        }
        return back()->withSuccess('Verifikasi berhasil');
    }

    public function tolak(Request $request,Kematian $kematian){
        $warga = Warga::with('anggota_ruta')->where('nik',$kematian->dinamika->nik)->first();
        Storage::disk('public')->delete($kematian->bukti);
       $kematian->dinamika->delete();
        if($warga->has('anggota_ruta')){
            $hal ='Data Kematian ditolak';
            $kepala_ruta = User::whereHas("warga.anggota_ruta", function(Builder $builder) use($warga) {
                $builder->where('ruta_id', '=', $warga->anggota_ruta->ruta_id)->where('hubungan','Kepala Keluarga');
            })->first();
            if($kepala_ruta){
                $request['message'] = 'Data kematian ditolak untuk anggota rumah tangga anda '.$warga->nama.'['.$warga->nik.'].'.$request['message'];
                Notification::send($kepala_ruta, new Message('ketua RT',$hal,$request['message'],route('login')));
            }
           
        }

        $kematian->delete();
        
        return back()->withSuccess('Data kematian ditolak');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kematian $kematian)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kematian $kematian)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kematian $kematian)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kematian $kematian)
    {
        //
    }
}
