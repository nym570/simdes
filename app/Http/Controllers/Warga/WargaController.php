<?php

namespace App\Http\Controllers\Warga;

use App\Models\Warga;
use App\Models\RT;
use App\Models\Desa;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWargaRequest;
use App\Http\Requests\UpdateWargaRequest;
use App\DataTables\WargaDataTable;
use App\Imports\WargaImport;
use Illuminate\Database\Eloquent\Builder;

class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WargaDataTable $dataTable)
    {
        $title = 'Manajemen Warga';
		 return $dataTable->render('menu.warga.index',compact('title'));
    }
    public function getWargaHidup(Request $request){
        if(isset($request['tujuan'])){
            $data = Warga::doesntHave($request['tujuan'])->where('status','warga')->get();
        }
        else if($request['warga']=='2'){
            $data = Warga::where('status','warga')->whereHas("rt", function(Builder $builder) {
                $builder->where('ketua_rt', '=', auth()->user()->roles->where('status','rt')->value('id'));
            })->get();
        }
       
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item['nama'].$item['nik']."' value='".$item['nik']."'>".$item['nik'].' | '.$item['nama']."</option>";
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
    public function store(StoreWargaRequest $request)
    {
        $desa = Desa::get()->first();
        $validated = $request->validated();
        if($validated['kode_wilayah_ktp']==$desa['kode_wilayah']){
            $validated['ktp_desa'] = 1;
        }
        else{
            $validated['ktp_desa'] = 0;
        }
        $validated['status'] = 'warga';
        if(auth()->user()->roles->where('status','rt')){
            $validated['rt_id'] = RT::where('ketua_rt',auth()->user()->roles->where('status','rt')->value('id'))->value('id');
        }
       
        $warga = Warga::create($validated);

        return back()->withSuccess('Data warga berhasil ditambahkan');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('import');
        $import = new WargaImport();
        $import->import($file);
        if(count($import->failures())>=1){
            return back()->withError('Import data warga gagal : '.count($import->failures()).' data');
        }
        else{
            return back()->withSuccess('Import data warga berhasil');
        }

        
    }
    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        $title = $warga->nama;
        return view('menu.warga.show',compact(['title','warga']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWargaRequest $request, Warga $warga)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        //
    }
}
