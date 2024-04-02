<?php

namespace App\Http\Controllers\Layanan;

use App\Models\Aspirasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AspirasiDataTable;

class AspirasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AspirasiDataTable $dataTable)
    {
        $title = 'Manajemen Aspirasi';
        return $dataTable->render('menu.aspirasi.index',compact('title'));
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
    public function show(Aspirasi $aspirasi)
    {
        $title = $aspirasi->judul;
        return view('menu.aspirasi.show',compact(['title','aspirasi']));
    }

    public function status(Aspirasi $aspirasi)
    {
        $data['is_open'] = false;
		if(!$aspirasi->is_open){
			$data['is_open'] = true;
		}
		$aspirasi->update($data);

		return back()->withSuccess('Status aspirasi berhasil diubah');
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
