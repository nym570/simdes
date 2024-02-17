<?php

namespace App\Http\Controllers\Warga;

use App\Models\Warga;
use App\Models\Desa;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWargaRequest;
use App\Http\Requests\UpdateWargaRequest;
use App\DataTables\WargaDataTable;

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
        $warga = Warga::create($validated);

        return back()->withSuccess('Data warga berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        //
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
