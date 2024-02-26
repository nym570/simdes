<?php

namespace App\Http\Controllers\Desa;

use App\Models\Pemerintahan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PemerintahanDataTable;

class PemerintahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PemerintahanTable $dataTable)
	 {
		$title = 'Manajemen Perangkat Desa';
		 return $dataTable->render('admin.desa.pemerintahan.index',compact('title'));
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
    public function show(Pemerintahan $pemerintahan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pemerintahan $pemerintahan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pemerintahan $pemerintahan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pemerintahan $pemerintahan)
    {
        //
    }
}
