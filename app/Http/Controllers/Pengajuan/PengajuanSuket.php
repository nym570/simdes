<?php

namespace App\Http\Controllers\Pengajuan;

use App\Models\SuratKeterangan;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\DataTables\PengajuanSuratKeteranganDataTable;

class PengajuanSuket extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(PengajuanSuratKeteranganDataTable $dataTable)
    {
        $title = 'Layanan Surat Keterangan';
        return $dataTable->render('menu.pengajuan.suket.index',compact(['title']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $data = $request->validate( [
            'jenis' => ['required','string'],
            'tingkat' => ['required','string'],
            'keperluan' => ['required','string'],
            'keterangan' => []
        ]);
        
        if(isset($request['dokumen_kk'])||isset($request['dokumen_ktp'])||isset($request['foto'])){
            $validasi = [];
            if(isset($request['dokumen_kk'])){
                $validasi['dokumen_kk'] = ['required','mimes:jpg,png'];
            }
            if(isset($request['dokumen_ktp'])){
                $validasi['dokumen_ktp'] = ['required','mimes:jpg,png'];
            }
            if(isset($request['foto'])){
                $validasi['foto'] = ['required','mimes:jpg,png'];
            }
            $Vdata = $request->validate($validasi);
            $warga = auth()->user()->warga;
            if($request->file('dokumen_kk')){
                
                $extension = $request->file('dokumen_kk')->extension();
                $Vdata['dokumen_kk'] = Storage::disk('public')->putFileAs('warga/kk', $request->file('dokumen_kk'),$warga['nik'].'_'.'kk_'.date('Ymd').'.'.$extension);
            }
            if($request->file('dokumen_ktp')){
                
                $extension = $request->file('dokumen_ktp')->extension();
                $Vdata['dokumen_ktp'] = Storage::disk('public')->putFileAs('warga/ktp', $request->file('dokumen_ktp'),$warga['nik'].'_'.'ktp_'.date('Ymd').'.'.$extension);
            }
            if($request->file('foto')){
                $extension = $request->file('foto')->extension();
                $Vdata['foto'] = Storage::disk('public')->putFileAs('warga/foto', $request->file('foto'),$warga['nik'].'_'.'foto_'.date('Ymd').'.'.$extension);
            }
    
            $warga->update($Vdata);
        }
        
        $data['nik'] = auth()->user()->nik;
        $data['user_id'] = auth()->user()->id;
        if($data['tingkat']=='desa'){
            $data['penanggung_jawab'] = 'desa';
            $data['verifikasi'] = 3;
            
        }
        else if($data['tingkat']=='rw'){
            $data['penanggung_jawab'] = auth()->user()->warga->rt->rw->name;
            $data['verifikasi'] = 2;
        }
        else if($data['tingkat']=='rt'){
            $data['penanggung_jawab'] = auth()->user()->warga->rt->name;
            $data['verifikasi'] = 1;
        }
        $data['status'] ='diajukan';
        $data['tracking'] ='menunggu verifikasi rt';
        SuratKeterangan::create($data);
        return back()->withSuccess('Surat Keterangan Berhasil Diajukan');
        
    }

    

    /**
     * Display the specified resource.
     */
    public function show(SuratKeterangan $suratKeterangan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, SuratKeterangan $suratKeterangan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuratKeterangan $suratKeterangan)
    {
        //
    }
}
