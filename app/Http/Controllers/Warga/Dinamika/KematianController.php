<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kematian;
use App\Models\Warga;
use App\Models\Ruta;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KematianDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
        $formatted_dt1=Carbon::createFromFormat('d M Y', $warga['tanggal_lahir']);
        $formatted_dt2=Carbon::parse($data['waktu']);
        $data['usia'] =  $formatted_dt1->diffInYears($formatted_dt2);
        if($request->file('bukti')){
            $extension = $request->file('bukti')->extension();
            $data['bukti'] = Storage::disk('public')->putFileAs('dinamika', $request->file('bukti'),date('Ymd').'_kematian_'.$data['nik'].'.'.$extension);
        }
        
        
        $kematian = Kematian::create($data);
        $kematian->dinamika()->create([ 'nik' => $data['nik'] ]);

       
        
        return back()->withSuccess('Data Kematian berhasil ditambahkan');
    }
    public function verifikasi(Kematian $kematian){
        $warga = Warga::where('nik',$kematian->dinamika->nik)->with('anggota_ruta')->first();
        $kematian->update(['verifikasi'=>true]);
        $warga->update(['status'=>'meninggal']);
        if(!is_null($warga->anggota_ruta)){
            $ruta = Ruta::where('id',$warga->anggota_ruta->ruta_id)->first();
        
        $temp['jumlah_art'] = $ruta['jumlah_art'] - 1;
        $warga->anggota_ruta->delete();
        if($temp['jumlah_art'] == 0){
            $ruta->delete();
        }
        else{
            $ruta->update($temp);
        }
        }
        return back()->withSuccess('Verifikasi berhasil');
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
