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
use Barryvdh\DomPDF\Facade\Pdf;


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
    public function tolak(Request $request,PengajuanInfoPublik $pengajuanInfoPublik)
    {
        $validateData = $request->validate([
			'kuasa' => ['required','string'],
			'penolakan' => ['required'],
            'keterangan' => ['required', 'string'],
		]);
        $validateData['penolakan'] = implode(', ', $validateData['penolakan']);
        $validateData['status'] = 'ditolak';
        $validateData['is_verified'] = false;
        $validateData['waktu'] = now();
        $pengajuanInfoPublik->update($validateData);
        $pdf = Pdf::loadView('surat.penolakan', ['permohonan' => $pengajuanInfoPublik]);
        $content = $pdf->download()->getOriginalContent();
        Storage::disk('public')->put('surat/pengajuan-info-publik/tolak/'.str_replace(array("/"), "-", $pengajuanInfoPublik->no_pendaftaran).'_'.$pengajuanInfoPublik->nik_pengaju.'_'.date('Ymd').'.pdf',$content);
        return back()->withSuccess('Permohonan Informasi berhasil ditolak');
    }
    public function setuju(Request $request,PengajuanInfoPublik $pengajuanInfoPublik)
    {
        $validateData = $request->validate([
			'kuasa' => ['required','string'],
			'biaya' => ['required'],
            'keterangan' => [],
		]);
        $validateData['status'] = 'diproses';
        $validateData['is_verified'] = true;
        $validateData['waktu'] = now();
        $pengajuanInfoPublik->update($validateData);
        return back()->withSuccess('Permohonan Informasi berhasil disetujui');
    }
    public function selesai(Request $request,PengajuanInfoPublik $pengajuanInfoPublik)
    {
        $validateData = $request->validate([
			'cara_bayar' => ['required'],
		]);
        $validateData['status'] = 'selesai';
        $validateData['is_verified'] = true;
        $validateData['waktu'] = now();
        $pengajuanInfoPublik->update($validateData);
        return back()->withSuccess('Permohonan Informasi berhasil diselesaikan');
    }
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
        
        $kode_wil = Desa::first()->kode_wilayah;
        $validateData['no_pendaftaran'] = sprintf("%03d",$validateData['no_urut'] ).'/PPID/'.$kode_wil.'/PIP/'.$filter->filter(date('m')).'/'.date('Y');
		if($request->file('lampiran')){
            $extension = $request->file('lampiran')->extension();
            $validateData['lampiran'] = Storage::disk('public')->putFileAs('pengajuan-info-publik', $request->file('lampiran'), str_replace(array("/"), "-", $validateData['no_pendaftaran']).'_'.$validateData['nik_pengaju'].'_'.date('Ymd').'.'.$extension);
        }
        $validateData['cara_perolehan'] = implode(',', $validateData['cara_perolehan']);
        $validateData['media_perolehan'] = implode(',', $validateData['media_perolehan']);
        $validateData['bukti'] = '';
        $permohonan = PengajuanInfoPublik::create($validateData);
        $pdf = Pdf::loadView('surat.permohonan', ['permohonan' => $permohonan]);
        $content = $pdf->download()->getOriginalContent();
        Storage::disk('public')->put('surat/pengajuan-info-publik/bukti/'.str_replace(array("/"), "-", $permohonan->no_pendaftaran).'_'.$permohonan->nik_pengaju.'_'.date('Ymd').'.pdf',$content);
        $updateData['bukti'] = 'surat/pengajuan-info-publik/bukti/'.str_replace(array("/"), "-", $permohonan->no_pendaftaran).'_'.$permohonan->nik_pengaju.'_'.date('Ymd').'.pdf';
        $permohonan->update($updateData);
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
