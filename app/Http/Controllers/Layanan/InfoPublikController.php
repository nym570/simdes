<?php

namespace App\Http\Controllers\Layanan;

use App\Models\InfoPublik;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\InfoPublikDataTable;
use App\DataTables\InfoDataTable;
use Illuminate\Support\Facades\Storage;

class InfoPublikController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(InfoPublikDataTable $dataTable)
    {
        $title = 'Manajemen Informasi Publik';
        return $dataTable->render('menu.info_publik.index',compact('title'));
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
			'judul' => 'required|string',
			'kategori' => 'required',
            'tahun' => 'required',
            'lampiran' => 'mimes:pdf',
            'keterangan' => [],
		]);
        
		if($request->file('lampiran')){
            $extension = $request->file('lampiran')->extension();
            $validateData['lampiran'] = Storage::disk('public')->putFileAs('info-publik', $request->file('lampiran'), $validateData['judul'].$validateData['tahun'].'_'.date('Ymd').'.'.$extension);
        }
        

		InfoPublik::create($validateData);
        return back()->withSuccess('Informasi Publik berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function get(InfoPublik $infoPublik)
    {
        return json_encode($infoPublik);
    }

    public function status(InfoPublik $infoPublik)
    {
        $data['is_show'] = false;
		if(!$infoPublik->is_show){
			$data['is_show'] = true;
		}
		$infoPublik->update($data);

		return back()->withSuccess('Status informasi publik berhasil diubah');
    }
    public function delete(InfoPublik $infoPublik)
    {
        if($infoPublik->lampiran){
            Storage::disk('public')->delete($infoPublik->lampiran);
        }
        $infoPublik->delete();
		return back()->withSuccess('Informasi Publik Berhasil dihapus');
    }

    public function show(InfoDataTable $dataTable)
    {
        $title = 'Informasi Publik';
        return $dataTable->render('info',compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(InfoPublik $infoPublik)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, InfoPublik $infoPublik)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(InfoPublik $infoPublik)
    {
        //
    }
}
