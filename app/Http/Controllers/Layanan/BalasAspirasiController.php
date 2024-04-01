<?php

namespace App\Http\Controllers\Layanan;

use App\Models\BalasAspirasi;
use App\Models\Aspirasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class BalasAspirasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $validateData = $request->validate([
            'lampiran' => 'mimes:jpg,png,pdf|max:1024',
            'isi' => 'required',
            'aspirasi_id' => 'required'
		]);
        
		if($request->file('lampiran')){
            $validateData['lampiran'] = Storage::disk('public')->putFile('aspirasi', $request->file('lampiran'));
        }
        
        $validateData['user_id'] = auth()->user()->id;
        $aspirasi = Aspirasi::where('id',$validateData['aspirasi_id'])->touch();
		BalasAspirasi::create($validateData);

		return back()->withSuccess('Balasan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BalasAspirasi $balasAspirasi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BalasAspirasi $balasAspirasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BalasAspirasi $balasAspirasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BalasAspirasi $balasAspirasi)
    {
        //
    }
}
