<?php

namespace App\Http\Controllers\Warga;

use App\Models\Ruta;
use App\Models\RT;
use App\Models\Warga;
use App\Models\AnggotaRuta;
use App\Http\Controllers\Controller;
use App\DataTables\RutaDataTable;
use App\DataTables\AnggotaRutaDataTable;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Imports\RutaImport;
use App\Imports\AnggotaRutaImport;
use Illuminate\Support\Facades\Validator;

class RutaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(RutaDataTable $dataTable)
    {
        $title = 'Manajemen Rumah Tangga';
		 return $dataTable->render('menu.ruta.index',compact('title'));
    }

    public function getWargaNonRuta()
    {
        $warga = Warga::whereIn('status',['warga','sementara tidak berdomisili'])->whereHas("rt", function(Builder $builder) {
            $builder->where('pemimpin', '=', auth()->user()->id);
        })->doesntHave('anggota_ruta')->get();
        if($warga){
            foreach($warga as $item){
                echo "<option data-tokens='".$item['nik'].$item['nama']."' value='".$item['nik']."'>".$item['nik'].' | '.$item['nama']."</option>";
            }
        }
    }
    public function getKepalaRuta()
    {
        $kepala = AnggotaRuta::where('hubungan','Kepala Keluarga')->with(['warga','warga.anggota_ruta'])->whereHas("ruta.rt", function(Builder $builder) {
            $builder->where('pemimpin', '=', auth()->user()->id);
        })->get();
        if($kepala){
            foreach($kepala as $item){
                echo "<option data-tokens='".$item->warga->nik.$item->warga->nama."' value='".$item->warga->anggota_ruta->ruta_id."'>".$item->warga->nik.' | '.$item->warga->nama."</option>";
            }
        }
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
        $validated =$request->validate([
			'alamat_domisili' => ['required','string'],
            'kepala_ruta' => ['required','unique:anggota_ruta,anggota_nik','exists:warga,nik'],
		]);
            $validated['rt_id'] = auth()->user()->warga->rt_id;
        $validated['jumlah_art'] = 1;
        $ruta = Ruta::create($validated)->id;
        $kepala = [
            'anggota_nik' => $validated['kepala_ruta'],
            'hubungan' => 'Kepala Keluarga',
            'ruta_id' => $ruta,
        ];
        $anggota_ruta = AnggotaRuta::create($kepala);
        return back()->withSuccess('Rumah Tangga Berhasil ditambahkan');
    }
    public function storeAnggota(Ruta $ruta,Request $request)
    {
        
        $validated = $request->validate([
			'anggota_nik' => ['required','string','size:16','unique:anggota_ruta,anggota_nik'],
			'hubungan' => ['required','string'],
            
		]);
        
        
        $anggota = [
            'anggota_nik' => $validated['anggota_nik'],
            'hubungan' => $validated['hubungan'],
            'ruta_id' => $ruta->id,
        ];
        $anggota_ruta = AnggotaRuta::create($anggota);
        $data['jumlah_art'] = $ruta['jumlah_art'] + 1;
        $ruta->update($data);
        return back()->withSuccess('Anggota Rumah Tangga Berhasil ditambahkan');
    }


    /**
     * Display the specified resource.
     */
    public function show(Ruta $ruta,AnggotaRutaDataTable $dataTable)
    {
        $title = 'Rumah Tangga';
        $kepala = $ruta->anggota_ruta->where('hubungan','Kepala Keluarga')->value('anggota_nik');
		 return $dataTable->with('ruta_id', $ruta->id)->render('menu.ruta.show',compact('title','ruta','kepala'));
    }
    public function getAnggota(Request $request)
    {
        if(isset($request['id'])){
            $data = AnggotaRuta::with(['warga'])->where('ruta_id',$request['id'])->get();
            if($data){
                foreach($data as $item){
                        echo "<option data-tokens='".$item->warga->nik."' value='".$item->warga->nik."'>".$item->warga->nik.' | '.$item->warga->nama."</option>";
                }
            }
        }
        else{
            $data = AnggotaRuta::where('ruta_id',$request['id'])->with('warga')->get();
            if($data){
                if(isset($request['all'])){
                    foreach($data as $item){

                            echo "<option data-tokens='".$item->warga->nik.$item->warga->nama."' value='".$item->warga->nik."'>".$item->warga->nik.' | '.$item->warga->nama."</option>";
                        
                    }
                }
                else{
                    foreach($data as $item){
                        if($item->hubungan != 'Kepala Keluarga'){
                            echo "<option data-tokens='".$item->warga->nik.$item->warga->nama."' value='".$item->warga->nik."'>".$item->warga->nik.' | '.$item->warga->nama."</option>";
                        }
                        
                    }
                }
                
            }
        }
        
        
    }
    public function import(Request $request)
    {
        $validasi = [];
        if(isset($request['ruta'])){
            $validasi['ruta'] = 'mimes:csv,xls,xlsx';
        }
        if(isset($request['anggota'])){
            $validasi['anggota'] = 'mimes:csv,xls,xlsx';
        }
        $data = Validator::make($request->all(), $validasi);
        if ($data->fails()) {
            return back()->withError('Upload file gagal, tipe file salah');
        }
        else{
            if(isset($request['ruta'])){
                $file1 = $request->file('ruta');
                $import1 = new RutaImport();
                $import1->import($file1);

            }
            if(isset($request['anggota'])){
                $file2 = $request->file('anggota');
                $import2 = new AnggotaRutaImport();
                $import2->import($file2);

            }
        }
        
        if(isset($request['ruta'])&&isset($request['anggota'])&&count($import1->failures())>=1&&count($import2->failures())>=1){
            return back()->withError('Import data ruta gagal : '.count($import1->failures()).' data & Import data anggota gagal : '.count($import1->failures()).' data');
        }
        else if(isset($request['ruta'])&&count($import1->failures())>=1){
            return back()->withError('Import data ruta gagal : '.count($import1->failures()).' data');
        }
        else if(isset($request['anggota'])&&count($import2->failures())>=1){
            return back()->withError('Import data anggota gagal : '.count($import2->failures()).' data');
        }
        else{
            return back()->withSuccess('Import data ruta berhasil');
        }

        
    }

    public function updateKepala(Request $request)
    {
        if(isset($request['nik_lama'])){
            $lama = AnggotaRuta::where('anggota_nik',$request['nik_lama']);
            $data['hubungan'] = $request['hubungan_lama'];
            $lama->update($data);
           
        }
        $kepala = AnggotaRuta::where('anggota_nik',$request['kepala_nik']);
        $data['hubungan'] = 'Kepala Keluarga';
        $kepala->update($data);
        return back()->withSuccess('Kepala Rumah Tangga Berhasil diubah');
        
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruta $request)
    {
        $keterangan = ['rw_id' => $request->rt->rw_id, 'link' =>route('ruta.update',$request)];
        $data = ['ruta' => $request, 'keterangan' => $keterangan];

        return json_encode($data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Ruta $ruta)
    {
        $validated = $validated =$request->validate([
			'alamat_domisili' => ['required','string'],
            
		]);
        $ruta->update($validated);

        return back()->withSuccess('Rumah Tangga Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruta $ruta)
    {
        AnggotaRuta::where('ruta_id', $ruta->id)->delete();
        $ruta->delete();
		return back()->withSuccess('Rumah Tangga Berhasil dihapus');
    }
    public function anggotaDestroy(AnggotaRuta $anggota)
    {
        $ruta = Ruta::where('id',$anggota->ruta_id)->first();
        $data['jumlah_art'] = $ruta['jumlah_art'] - 1;
        
        
        if($data['jumlah_art'] == 0){
            $ruta->delete();
            return to_route('ruta.index')->withSuccess('Anggota Rumah Tangga Berhasil dihapus');
        }
        else{
            if($anggota->hubungan =='Kepala Keluarga'){
                $lain = AnggotaRuta::where('ruta_id',$anggota->ruta_id)->where('anggota_nik','!=',$anggota->anggota_nik)->orderBy('hubungan')->first();
                $lain->update(['hubungan'=>'Kepala Keluarga']);
            }
            $ruta->update($data);
           
        }
        $anggota->delete();
        return back()->withSuccess('Anggota Rumah Tangga Berhasil dihapus');
    }
    public function anggotaUpdate(Request $request, AnggotaRuta $anggota)
    {
        $validated = $request->validate([
			'hubungan' => ['required','string'],
            
		]);
        $anggota->update($validated);
        return back()->withSuccess('Hubungan Anggota Ruta Berhasil Diubah');
       
        
		
    }
}
