<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kedatangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KedatanganDataTable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
