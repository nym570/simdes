<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kepindahan;
use App\Models\Warga;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KepindahanDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
        
        $nik = $request['nik'];
        $data = $request->validate([
			'alamat_pindah' => ['required','string'],
            'waktu' => ['required','date'],
            'penyebab' => ['required','string'],
            'jenis' => ['required','string'],
            'kode_wilayah_pindah' => ['required','string','size:13'],
            'bukti' => ['mimes:jpg,png,pdf','max:1024'],
		]);
        if(isset($request['keterangan'])){
            $data['keterangan'] = $request['keterangan'];
        }
        
        if($request->file('bukti')){
            $extension = $request->file('bukti')->extension();
            $data['bukti'] = Storage::disk('public')->putFileAs('dinamika', $request->file('bukti'),date('Ymd').'_kepindahan_'.'.'.$extension);
        }
        $kepindahan = Kepindahan::create($data);
       
        foreach($nik as $item){
            $kepindahan->dinamika()->create([ 'nik' => $item ]);
        }
        return back()->withSuccess('Data Kepindahan berhasil ditambahkan');
    }

    public function verifikasi(Kepindahan $kepindahan){
        foreach($kepindahan->dinamika as $item){
            $warga = Warga::where('nik',$item->nik)->with('anggota_ruta.ruta')->first();
            
            $warga->update(['status'=>'pindah']);
            
            if(!is_null($warga->anggota_ruta)){
            
            $temp['jumlah_art'] = $warga->anggota_ruta->ruta->jumlah_art - 1;
            $warga->anggota_ruta->delete();
            if($temp['jumlah_art'] == 0){
                $warga->anggota_ruta->ruta->delete();
            }
            else{
                $warga->anggota_ruta->ruta->update($temp);
            }
        }
        }
        $kepindahan->update(['verifikasi'=>true]);
        return back()->withSuccess('Verifikasi berhasil');
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
