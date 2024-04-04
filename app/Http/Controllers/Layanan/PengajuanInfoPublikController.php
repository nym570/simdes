<?php

namespace App\Http\Controllers\Layanan;

use App\Models\PengajuanInfoPublik;
use App\Models\Desa;
use App\DataTables\PengajuanInfoPublikDataTable;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Romans\Filter\IntToRoman;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
        $filter = new IntToRoman();
        $validateData = $request->validate([
			'nama' => ['required','string'],
			'nik_pengaju' => ['required','string','size:16'],
            'no_telp' => ['required', 'string','regex:/62[0-9]+$/u'],
            'email' => ['required','email'],
            'alamat' => ['required'],
            'pekerjaan' => ['required'],
            'tujuan' => ['required'],
            'rincian' => ['required'],
            'cara_perolehan' => ['required'],
            'media_perolehan' => ['required'],
            'lampiran' => ['mimes:pdf'],
		]);
        $last = PengajuanInfoPublik::whereYear('created_at',date('Y-m-d'))->latest()->first();
        if($last){
            $validateData['no_urut'] = $last->no_urut+1;
        }
        else{
            $validateData['no_urut'] = 1;
        }
        $validateData['bukti'] = 'hai';
        $kode_wil = Desa::first()->kode_wilayah;
        $validateData['no_pendaftaran'] = sprintf("%03d",$validateData['no_urut'] ).'/PPID/'.$kode_wil.'/PIP/'.$filter->filter(date('m')).'/'.date('Y');
		if($request->file('lampiran')){
            $extension = $request->file('lampiran')->extension();
            $validateData['lampiran'] = Storage::disk('public')->putFileAs('pengajuan-info-publik', $request->file('lampiran'), $validateData['no_pendaftaran'].'_'.$validateData['nik_pengaju'].'_'.date('Ymd').'.'.$extension);
        }
        $validateData['cara_perolehan'] = implode(',', $validateData['cara_perolehan']);
        $validateData['media_perolehan'] = implode(',', $validateData['media_perolehan']);
        PengajuanInfoPublik::create($validateData);
        return back()->withSuccess('Permohonan Informasi berhasil diajukan');
        
    }

    public function cek(Request $request)
    {
        $validateData = $request->validate([
			'email_cek' => ['required','email','exists:pengajuan_info_publik,email'],
			'nik' => ['required','string','size:16','exists:pengajuan_info_publik,nik_pengaju'],
            'no_pendaftaran' => ['required', 'string','exists:pengajuan_info_publik,no_pendaftaran'],
		]);
        $data = PengajuanInfoPublik::where('email',$validateData['email_cek'])->where('nik_pengaju',$validateData['nik'])->where('no_pendaftaran', $validateData['no_pendaftaran'])->first();
        if($data){
           return to_route('pengajuan-info.info',$data);
        }
        else{
            return back()->withError('Data pengajuan tidak cocok dengan data kami');
        }
        
        
    }

    /**
     * Display the specified resource.
     */
    public function show(PengajuanInfoPublik $pengajuanInfoPublik)
    {
        $title = 'Permohonan : '.$pengajuanInfoPublik->no_pendaftaran;
        return view('menu.pengajuan.info.show',compact(['title','pengajuanInfoPublik']));
    }

    public function list(PengajuanInfoPublikDataTable $dataTable)
    {
        $title = 'Manajemen Permohonan Informasi Publik';
        return $dataTable->render('menu.info_publik.permohonan.index',compact('title'));
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
