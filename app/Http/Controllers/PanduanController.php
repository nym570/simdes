<?php

namespace App\Http\Controllers;

use App\Models\Panduan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PanduanDataTable;
use App\DataTables\PanduanShowDataTable;
use Illuminate\Support\Facades\Storage;

class PanduanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PanduanDataTable $dataTable)
    {
        $title = 'Manajemen Panduan';
        return $dataTable->render('admin.panduan',compact('title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validateData = $request->validate([
			'judul' => 'required|string',
			'kategori' => 'required',
            'lampiran' => 'mimes:pdf',
            'keterangan' => 'required',
		]);
        
		if($request->file('lampiran')){
            $extension = $request->file('lampiran')->extension();
            $validateData['lampiran'] = Storage::disk('public')->putFileAs('panduan', $request->file('lampiran'), $validateData['judul'].'_'.date('Ymd').'.'.$extension);
        }

		Panduan::create($validateData);
        return back()->withSuccess('Panduan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function get(Panduan $panduan)
    {
        return json_encode($panduan);
    }

    public function status(Panduan $panduan)
    {
        $data['is_show'] = false;
		if(!$panduan->is_show){
			$data['is_show'] = true;
		}
		$panduan->update($data);

		return back()->withSuccess('Status informasi publik berhasil diubah');
    }
    public function delete(Panduan $panduan)
    {
        if($panduan->lampiran){
            Storage::disk('public')->delete($panduan->lampiran);
        }
        $panduan->delete();
		return back()->withSuccess('Panduan Berhasil dihapus');
    }

    public function show(PanduanShowDatatable $dataTable)
    {
        $title = 'Panduan';
        return $dataTable->render('panduan',compact('title'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Panduan $panduan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Panduan $panduan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Panduan $panduan)
    {
        //
    }
}
