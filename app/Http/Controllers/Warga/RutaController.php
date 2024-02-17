<?php

namespace App\Http\Controllers\Warga;

use App\Models\Ruta;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRutaRequest;
use App\Http\Requests\UpdateRutaRequest;
use App\DataTables\RutaDataTable;

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
    public function store(StoreRutaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Ruta $ruta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Ruta $ruta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRutaRequest $request, Ruta $ruta)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Ruta $ruta)
    {
        //
    }
}
