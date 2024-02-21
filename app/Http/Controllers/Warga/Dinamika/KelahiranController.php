<?php

namespace App\Http\Controllers\Warga\Dinamika;

use App\Models\Kelahiran;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\KelahiranDataTable;

class KelahiranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(KelahiranDataTable $dataTable)
    {
        $title = 'Kelahiran';
		 return $dataTable->render('menu.dinamika.kelahiran.index',compact('title'));
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
    public function show(Kelahiran $kelahiran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kelahiran $kelahiran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kelahiran $kelahiran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kelahiran $kelahiran)
    {
        //
    }
}
