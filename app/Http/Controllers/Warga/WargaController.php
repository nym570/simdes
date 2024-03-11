<?php

namespace App\Http\Controllers\Warga;

use App\Models\Warga;
use App\Models\RT;
use App\Models\Desa;
use App\Models\User;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\StoreWargaRequest;
use App\Http\Requests\UpdateWargaRequest;
use App\DataTables\WargaDataTable;
use App\Imports\WargaImport;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Notifications\Message;
use Illuminate\Support\Facades\Notification;
use Jenssegers\Date\Date;


class WargaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WargaDataTable $dataTable)
    {
        $title = 'Manajemen Warga';
		 return $dataTable->render('menu.warga.index',compact('title'));
    }
    public function get(Warga $warga)
    {
        $warga['tanggal_format'] =  $formatted_dt1=Date::createFromFormat('d M Y', $warga->tanggal_lahir);
		return json_encode($warga);
    }
    public function getWargaHidup(Request $request){
        if(isset($request['tujuan'])){
            $data = Warga::doesntHave($request['tujuan'])->where('status','warga')->get();
        }
        else {
            $data = Warga::where('status','warga')->get();
        }
       
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item['nama'].$item['nik']."' value='".$item['nik']."'>".$item['nik'].' | '.$item['nama']."</option>";
            }
        }
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
    public function store(StoreWargaRequest $request)
    {
        $desa = Desa::get()->first();
        $validated = $request->validated();
        if($validated['kode_wilayah_ktp']==$desa['kode_wilayah']){
            $validated['ktp_desa'] = 1;
        }
        else{
            $validated['ktp_desa'] = 0;
        }
        $validated['status'] = 'warga';
        $validated['rt_id'] = auth()->user()->warga->rt_id;
        $validated['tempat_lahir'] = Str::title($validated['tempat_lahir']);
        
       
        $warga = Warga::create($validated);

        return back()->withSuccess('Data warga berhasil ditambahkan');
    }

    public function domisili(Request $request, Warga $warga)
    {
        $data = $request->validate([
            'rt_id' => ['required','exists:rt,id'],
        ]);

        $warga->update($data);
        return back()->withSuccess('Domisili warga berhasil diubah');
    }

    public function message(Request $request, Warga $warga)
    {
        $data = $request->validate([
            'message' => ['required','string'],
        ]);
        $user = User::where('nik',$warga->nik)->first();
        $role_pengirim = auth()->user()->roles->pluck('category')->toArray();
        $cakupan_pengirim = auth()->user()->roles->pluck('status')->toArray();
        $hal ='Update Data Kependudukan';
        $pengirim = '';
        if(auth()->user()->hasRole('kependudukan')){
            $pengirim = 'Kependudukan Desa';
        }
        else if(in_array('dusun',$cakupan_pengirim)){
            $pengirim = 'kepala Dusun';
        }
        else if(in_array('rw',$cakupan_pengirim)){
            $pengirim = 'ketua RW';
        }
        else if(in_array('rt',$cakupan_pengirim)){
            $pengirim = 'ketua RT';
        }
        $pengirim = auth()->user()->warga->nama .'('.$pengirim.')';
        Notification::send($user, new Message($pengirim,$hal,$request['message'],route('login')));
        return back()->withSuccess('Pesan berhasil dikirim');
    }
    public function messageRT(Request $request, Warga $warga)
    {
        $data = $request->validate([
            'message' => ['required','string'],
        ]);
        $rt = $warga->rt->name;
        $user = User::role($rt)->first();
        $role_pengirim = auth()->user()->roles->pluck('category')->toArray();
        $cakupan_pengirim = auth()->user()->roles->pluck('status')->toArray();
        $hal ='Update Data Kependudukan : '. $warga->nik. '('.$warga->nama.')';
        $pengirim = '';
        if(auth()->user()->hasRole('kependudukan')){
            $pengirim = 'Kependudukan Desa';
        }
        else if(in_array('dusun',$cakupan_pengirim)){
            $pengirim = 'kepala Dusun';
        }
        else if(in_array('rw',$cakupan_pengirim)){
            $pengirim = 'ketua RW';
        }
        else if(in_array('rt',$cakupan_pengirim)){
            $pengirim = 'ketua RT';
        }
        $pengirim = auth()->user()->warga->nama .'('.$pengirim.')';
        Notification::send($user, new Message($pengirim,$hal,$request['message'],route('login')));
        return back()->withSuccess('Pesan berhasil dikirim');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'import' => 'required|mimes:csv,xls,xlsx'
        ]);
        $file = $request->file('import');
        $import = new WargaImport();
        $import->import($file);
        if(count($import->failures())>=1){
            return back()->withError('Import data warga gagal : '.count($import->failures()).' data');
        }
        else{
            return back()->withSuccess('Import data warga berhasil');
        }

        
    }
    public function dokumen(Request $request,Warga $warga)
    {
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
        $data = Validator::make($request->all(), $validasi);
        if ($data->fails()) {
            return back()->withError('Upload file gagal');
        }
        $data = $data->valid();

        if($request->file('dokumen_kk')){
            if(!is_null($warga['dokumen_kk'])){
                Storage::disk('public')->delete($warga['dokumen_kk']);
            }
            
            $extension = $request->file('dokumen_kk')->extension();
            $data['dokumen_kk'] = Storage::disk('public')->putFileAs('warga/kk', $request->file('dokumen_kk'),$warga['nik'].'_'.'kk_'.date('Ymd').'.'.$extension);
        }
        if($request->file('dokumen_ktp')){
            if(!is_null($warga['dokumen_ktp'])){
                Storage::disk('public')->delete($warga['dokumen_ktp']);
            }
            
            $extension = $request->file('dokumen_ktp')->extension();
            $data['dokumen_ktp'] = Storage::disk('public')->putFileAs('warga/ktp', $request->file('dokumen_ktp'),$warga['nik'].'_'.'ktp_'.date('Ymd').'.'.$extension);
        }
        if($request->file('foto')){
            if(!is_null($warga['foto'])){
                Storage::disk('public')->delete($warga['foto']);
            }
            
            $extension = $request->file('foto')->extension();
            $data['foto'] = Storage::disk('public')->putFileAs('warga/foto', $request->file('foto'),$warga['nik'].'_'.'foto_'.date('Ymd').'.'.$extension);
        }

        $warga->update($data);
        return back()->withSuccess('Dokumen berhasil di upload');
        
    }
    /**
     * Display the specified resource.
     */
    public function show(Warga $warga)
    {
        $title = $warga->nama;
        return view('menu.warga.show',compact(['title','warga']));
    }
    public function status(Request $request, Warga $warga)
	{
		$data['status'] = 'warga';
		if($warga['status']=='warga'){
			$data['status'] = 'sementara tidak berdomisili';
		}
		$warga->update($data);

		return back()->withSuccess('Status warga '.$warga->nik.' berhasil diubah');
	}
    public function getDokumen(Request $request)
    {
		return json_encode(Warga::where('nik',$request['nik'])->select('dokumen_ktp','dokumen_kk','foto')->first());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warga $warga)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWargaRequest $request, Warga $warga)
    {
        $validated = $request->validated();
        $warga->update($validated);
        return back()->withSuccess('Data warga berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warga $warga)
    {
        //
    }
}
