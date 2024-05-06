<?php

namespace App\Http\Controllers\Layanan;

use App\Models\SuratKeterangan;
use App\Models\Desa;
use App\Models\AnggotaRuta;
use App\Models\Warga;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\SuratKeteranganDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Romans\Filter\IntToRoman;
use Barryvdh\DomPDF\Facade\Pdf;
use Jenssegers\Date\Date;
use App\Notifications\SuketDiambil;
use Illuminate\Support\Facades\Notification;

class SuratKeteranganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SuratKeteranganDataTable $dataTable)
    {
        $title = 'Manajemen Surat Keterangan';
        return $dataTable->render('menu.suket.index',compact(['title']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function verifikasi(Request $request,SuratKeterangan $suratKeterangan)
    {
        
        $filter = new IntToRoman();
        $data['verifikasi'] = $suratKeterangan->verifikasi - 1;
        if($data['verifikasi']==0){
            
            $data['tracking'] = 'disetujui dan diproses';
            $data['status'] = 'diproses';
            $kode_wil = Desa::first()->kode_wilayah;
            $view = 'index';
            if($suratKeterangan['tingkat']=='desa'){
                $last_count = SuratKeterangan::whereYear('created_at',date('Y-m-d'))->where('jenis',$suratKeterangan['jenis'])->where('penanggung_jawab',$suratKeterangan['penanggung_jawab'])->where('verifikasi',0)->count();
                if($suratKeterangan['jenis']=='domisili'){
                    $data['no_surat'] = '470/'.sprintf("%03d",$last_count+1 ).'/'.$kode_wil.'/'.$filter->filter(date('m')).'/'.date('Y');
                    $view = 'surat.domisili';
                }
                if($suratKeterangan['jenis']=='umum'){
                    $data['no_surat'] = '140/'.sprintf("%03d",$last_count+1 ).'/'.$kode_wil.'/'.$filter->filter(date('m')).'/'.date('Y');
                    $view = 'surat.umum';
                }
            }
            else{
                $last_count = SuratKeterangan::whereYear('created_at',date('Y-m-d'))->where('penanggung_jawab',$suratKeterangan['penanggung_jawab'])->where('verifikasi',0)->count();
                $data['no_surat'] = sprintf("%03d",$last_count+1 ).'/'.str_replace(array("/"), ".",str_replace(" ","",$suratKeterangan['penanggung_jawab'])).'/'.$kode_wil.'/'.$filter->filter(date('m')).'/'.date('Y');
                if($suratKeterangan['jenis']=='domisili'){
                    $view = 'surat.domisili_lkd';
                }
                if($suratKeterangan['jenis']=='umum'){
                    $view = 'surat.umum_lkd';
                }
            }
           
            
            $temp = [];
            if(isset($request['keterangan'])){
                $data['keterangan'] = $request['keterangan'];
                $temp['keterangan'] = $request['keterangan'];
            }
            $temp['no'] = $data['no_surat'];
            $temp['alamat'] = AnggotaRuta::where('anggota_nik',$suratKeterangan['nik'])->first()->ruta->alamat_domisili;
            $temp['waktu'] = Date::now()->format('d F Y');
            $pdf = Pdf::loadView($view, ['suratKeterangan' => $suratKeterangan,'temp'=>$temp]);
            $content = $pdf->download()->getOriginalContent();
            Storage::disk('public')->put('surat/suket/file/'.str_replace(array("/"), "-", $data['no_surat']).'_'.$suratKeterangan->nik.'_'.date('Ymd').'.pdf',$content);
            $data['file'] = 'surat/suket/file/'.str_replace(array("/"), "-", $data['no_surat']).'_'.$suratKeterangan->nik.'_'.date('Ymd').'.pdf';
            
        }
        else{
            $data['tracking'] = 'menunggu verifikasi rw';
            if($suratKeterangan->tingkat == 'desa' && $data['verifikasi']==1){
                $data['tracking'] = 'menunggu verifikasi desa';
            }
        }
        $suratKeterangan->update($data);

		return back()->withSuccess('Pengajuan Surat Keterangan Berhasil di verifikasi');
    }
    public function setuju(Request $request,SuratKeterangan $suratKeterangan)
    {
        $data['tracking'] = 'menunggu untuk diambil oleh pengaju';
        $data['status'] = 'dapat diambil';
        
        $suratKeterangan->update($data);
        if($suratKeterangan->user->nik==$suratKeterangan->nik){
            $hal ='Surat Keterangan Dapat Diambil';
            Notification::send($suratKeterangan->user, new SuketDiambil($suratKeterangan->penanggung_jawab,$suratKeterangan->no_surat,$request['message']));
        }
        else{
            $telp = Warga::where('nik',$suratKeterangan->nik)->value('no_telp');
            $url = "https://wa.me/".$telp."?text=".str_replace(" ",'%20',$request['message']);
            session()->flash('url', $url);
        }
        
		return back()->withSuccess('Pengajuan Surat Keterangan Selesai Diproses & Dapat Diambil');
    }
    public function selesai(Request $request,SuratKeterangan $suratKeterangan)
    {
        $data['tracking'] = 'selesai';
        $data['status'] = 'selesai';
        $suratKeterangan->update($data);
		return back()->withSuccess('Pengajuan Surat Keterangan telah diselesaikan');
    }
    public function create()
    {
        //
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
            'nik' => ['required','size:16'],
            'keterangan' => []
        ]);
        $warga = Warga::where('nik',$data['nik'])->first();
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

            if($request->file('dokumen_kk')){
                
                $extension = $request->file('dokumen_kk')->extension();
                $Vdata['dokumen_kk'] = Storage::disk('public')->putFileAs('warga/kk', $request->file('dokumen_kk'),$data['nik'].'_'.'kk_'.date('Ymd').'.'.$extension);
            }
            if($request->file('dokumen_ktp')){
                
                $extension = $request->file('dokumen_ktp')->extension();
                $Vdata['dokumen_ktp'] = Storage::disk('public')->putFileAs('warga/ktp', $request->file('dokumen_ktp'),$data['nik'].'_'.'ktp_'.date('Ymd').'.'.$extension);
            }
            if($request->file('foto')){
                $extension = $request->file('foto')->extension();
                $Vdata['foto'] = Storage::disk('public')->putFileAs('warga/foto', $request->file('foto'),$data['nik'].'_'.'foto_'.date('Ymd').'.'.$extension);
            }
    
            $warga->update($Vdata);
        }
        $data['user_id'] = auth()->user()->id;
        if($data['tingkat']=='desa'){
            $data['penanggung_jawab'] = 'desa';
            $data['verifikasi'] = 3;
            
        }
        else if($data['tingkat']=='rw'){
            $data['penanggung_jawab'] = $warga->rt->rw->name;
            $data['verifikasi'] = 2;
        }
        else if($data['tingkat']=='rt'){
            $data['penanggung_jawab'] = $warga->rt->name;
            $data['verifikasi'] = 1;
        }
        $data['status'] ='diajukan';
        $data['tracking'] ='menunggu verifikasi rt';
        SuratKeterangan::create($data);
        return back()->withSuccess('Pengajuan Surat Keterangan Berhasil Ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(SuratKeterangan $suratKeterangan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuratKeterangan $suratKeterangan)
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
