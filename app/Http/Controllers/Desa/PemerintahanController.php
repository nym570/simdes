<?php

namespace App\Http\Controllers\Desa;

use App\Models\Pemerintahan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\PemerintahanDataTable;
use App\Rules\NIKExist;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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

    public function get(Request $request)
    {
		return json_encode(Pemerintahan::where('id',$request['id'])->with('warga:nik,nama')->first());
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
        $validasi = [
            'jabatan' => ['required','string','unique:pemerintahan,jabatan,'. $pemerintahan->id],
        ];
        
        if(!is_null($request['nik'])){
            $validasi['nik'] = ['required', 'string','size:16','unique:pemerintahan,nik',new NIKExist];
        }
        if(isset($request['foto'])){
            $validasi['foto'] = [ 'mimes:jpg,png','max:1024'];
        }
        $data = Validator::make($request->all(), $validasi);
        if ($data->fails()) {
            return back()->withError('Update perangkat gagal');
        }
        $data = $data->valid();
        $data['nik'] = $request['nik_current'];
        $data['tugas'] = $request['tugas'];
        $data['wewenang'] = $request['wewenang'];
        
        
        if($request->file('foto')){
            $extension = $request->file('foto')->extension();
            $data['foto'] = Storage::disk('public')->putFileAs('pemerintahan', $request->file('foto'),date('Ymd').'_'.$data['jabatan'].'_'.$data['nik'].'.'.$extension);
            if(isset($request['current_foto_path'])){
                Storage::disk('public')->delete($request['current_foto_path']);
            }
            
        }
        $pemerintahan->update($data);
        return back()->withSuccess('Data perangkat desa berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function delete(Pemerintahan $pemerintahan)
    {
        $pemerintahan->delete();
		return back()->withSuccess('Perangkat Desa Berhasil dihapus');
    }
}
