<?php

namespace App\Http\Controllers\Desa;

use App\Models\Pemerintahan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PemerintahanDataTable;
use App\Rules\NIKExist;
use Illuminate\Support\Facades\Storage;

class PemerintahanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PemerintahanDataTable $dataTable)
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
        $data = $request->validate([
			'nik' => ['required', 'string','size:16','unique:pemerintahan,nik',new NIKExist],
            'jabatan' => ['required','string','unique:pemerintahan,jabatan'],
			'tugas' => ['required'],
			'wewenang' => ['required'],
            'foto' => [ 'mimes:jpg,png','max:1024'],
		]);
        if($request->file('foto')){
            $extension = $request->file('foto')->extension();
            $data['foto'] = Storage::disk('public')->putFileAs('pemerintahan', $request->file('foto'),date('Ymd').'_'.$data['jabatan'].'_'.$data['nik'].'.'.$extension);
        }
        $pemerintahan = Pemerintahan::create($data);
        return back()->withSuccess('Data perangkat desa berhasil ditambahkan');

    }

    /**
     * Display the specified resource.
     */
    public function show(Pemerintahan $pemerintahan)
    {
        $title = 'Lihat '.$pemerintahan->jabatan;
		return view('admin.desa.pemerintahan.show', compact(['pemerintahan','title']));
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
