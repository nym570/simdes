<?php

namespace App\Http\Controllers\Pengajuan;

use App\Models\Aspirasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AspirasiWargaDataTable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PengajuanAspirasi extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function index(AspirasiWargaDataTable $dataTable)
    {
        $title = 'Aspirasi Saya';
        return $dataTable->render('menu.pengajuan.aspirasi.index',compact('title'));
    }
    /**
     * Show the form for creating a new resource.
     */

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
			'judul' => 'required|string',
			'kategori' => 'required',
            'tingkat' => 'required',
            'lampiran' => 'mimes:jpg,png,pdf|max:1024',
            'isi' => 'required',
		]);
        
		if($request->file('lampiran')){
            $extension = $request->file('lampiran')->extension();
            $validateData['lampiran'] = Storage::disk('public')->putFileAs('aspirasi', $request->file('lampiran'), auth()->user()->id.'_'.date('Ymd').'.'.$extension);
        }
        
        $validateData['user_id'] = auth()->user()->id;

		Aspirasi::create($validateData);
        return back()->withSuccess('Aspirasi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspirasi $aspirasi)
    {
        $title = $aspirasi->judul;
        return view('menu.pengajuan.aspirasi.show',compact(['title','aspirasi']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspirasi $aspirasi)
    {
        //
    }
}
