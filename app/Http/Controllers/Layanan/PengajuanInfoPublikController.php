<?php

namespace App\Http\Controllers\Layanan;

use App\Models\PengajuanInfoPublik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PengajuanInfoPublikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Permohonan Informasi Publik';
        return view('menu.pengajuan.info.index',compact('title'));
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
    public function show(PengajuanInfoPublik $pengajuanInfoPublik)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PengajuanInfoPublik $pengajuanInfoPublik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PengajuanInfoPublik $pengajuanInfoPublik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PengajuanInfoPublik $pengajuanInfoPublik)
    {
        //
    }
}
