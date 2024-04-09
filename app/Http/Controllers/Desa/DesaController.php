<?php

namespace App\Http\Controllers\Desa;

use App\Models\Desa;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;
use App\Models\User;
use App\Models\Pemerintahan;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDesaRequest;
use App\Http\Requests\UpdateDesaRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\DataTables\DusunDataTable;
use App\DataTables\RWDataTable;
use App\DataTables\RTDataTable;
use Spatie\Permission\Models\Role;
use Image;
use File;

class DesaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = 'Manajemen Profil Desa';

		return view('admin.desa.desa', compact(['title']));
    }
    public function lkd(DusunDataTable $dusunDT, RWDataTable $rwDT, RTDataTable $rtDT)
    {
        return view('admin.desa.lkd', [
            'title' => 'Manajemen Desa',
            'dusunDT' => $dusunDT->html(),
            'rwDT' => $rwDT->html(),
            'rtDT' => $rtDT->html(),
            'allUsers' => User::all(),
        ]);

    }

    public function getDusun(DusunDataTable $dusunDT)
    {
        return $dusunDT->render('admin.desa.lkd');
    }

    public function getRW(RWDataTable $rwDT)
    {
        return $rwDT->render('admin.desa.lkd');
    }

    public function getRT(RTDataTable $rtDT)
    {
        return $rtDT->render('admin.desa.lkd');
    }

    public function storeDusun(Request $request)
    {
        $data = $request->validate([
			'name' => ['required','string','unique:dusun,name'],
		]);
        $data['name'] = 'Dusun '.$data['name'];
        $dusun = Dusun::create($data);
        
        return back()->withSuccess('Dusun berhasil ditambahkan');
    }
    public function storeRW(Request $request)
    {
        $data = $request->validate([
			'name' => ['required','integer'],
            'dusun_id' => ['required']
		]);
        $data['name'] = 'RW '.str_pad($data['name'], 2, '0', STR_PAD_LEFT);
        if (RW::where('name', $data['name'] )->exists()) {
            return back()->withError('RW Gagal ditambahkan karena telah ada');
        }
        

        RW::create($data);
        
        return back()->withSuccess('RW berhasil ditambahkan');
    }

    public function storeRT(Request $request)
    {
        $data = $request->validate([
			'name' => ['required','integer'],
            'rw_id' => ['required']
		]);
        $rw = RW::where('id',$data['rw_id'])->first();
        $data['name'] = $rw->name.'/RT '.str_pad($data['name'], 2, '0', STR_PAD_LEFT);
        if (RT::where('name', $data['name'] )->exists()) {
            return back()->withError('RT Gagal ditambahkan karena telah ada');
        }
        RT::create($data);
        
        return back()->withSuccess('RT berhasil ditambahkan');
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
    public function store(StoreDesaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        if(auth()->user()){
            if(!auth()->user()->hasVerifiedEmail()){
                return redirect(route('verification.notice'));
            }
        }
        $title = 'Profil Desa';
        $pemerintahan = Pemerintahan::with('warga')->get();
        $agregate = [
            'dusun' => Dusun::count(),
            'rw' => RW::count(),
            'rt' => RT::count()
        ];

		return view('menu.guest.profil-desa.show', compact(['title','agregate','pemerintahan']));
    }
    public function get()
    {
        $desa = Desa::with('pemimpin')->first();
        return json_encode($desa);
    }
    public function kades(Request $request)
    {
        $desa = Desa::first();
        $data = $request->validate([
			'pemimpin' => ['required','exists:users,id'],
            'user' =>[],            
		]);
        if($data['user']){
            $lama = User::where('id',$desa['pemimpin'])->first();
            $lama->removeRole('kepala desa');
        }
        $user = User::where('id',$data['pemimpin'])->first();
        $user->assignRole('kepala desa');
        $desa->update($data);
        return back()->withSuccess('Kepala Desa berhasil diupdate');
    }

    public function kadesDelete()
    {
        $desa = Desa::first();
        $data= [
            'pemimpin' => null,
        ];
            $lama = User::where('id',$desa['pemimpin'])->first();
            $lama->removeRole('kepala desa');
        $desa->update($data);
        return back()->withSuccess('Kepala Desa berhasil dihapus');
    }

    public function dusun(Dusun $dusun)
    {
        $data = [
            'lkd' => $dusun,
            'link' => route('m.lkd.dusun.kadus',$dusun),
            'delete' => route('m.lkd.dusun.kadus.hapus',$dusun),
        ];
        return json_encode($data);
    }

    public function kadus(Request $request, Dusun $dusun)
    {
        $data = $request->validate([
			'pemimpin' => ['required','exists:users,id'],
            'user' =>[],            
		]);
        if($data['user']){
            $lama = User::where('id',$dusun['pemimpin'])->first();
            $lama->removeRole('kepala dusun');
        }
        $user = User::where('id',$data['pemimpin'])->first();
        $user->assignRole('kepala dusun');
        $dusun->update($data);
        return back()->withSuccess('Kepala Dusun berhasil diupdate');
    }

    public function kadusDelete(Dusun $dusun)
    {
        $data= [
            'pemimpin' => null,
        ];
            $lama = User::where('id',$dusun['pemimpin'])->first();
            $lama->removeRole('kepala dusun');
        $dusun->update($data);
        return back()->withSuccess('Kepala Dusun berhasil dihapus');
    }

    public function rw(RW $rw)
    {
        $data = [
            'lkd' => $rw,
            'link' => route('m.lkd.rw.pemimpin',$rw),
            'delete' => route('m.lkd.rw.pemimpin.hapus',$rw),
        ];
        return json_encode($data);
    }

    public function ketuaRW(Request $request, RW $rw)
    {
        $data = $request->validate([
			'pemimpin' => ['required','exists:users,id'],
            'user' =>[],            
		]);
        if($data['user']){
            $lama = User::where('id',$rw['pemimpin'])->first();
            $lama->removeRole('ketua rw');
        }
        $user = User::where('id',$data['pemimpin'])->first();
        $user->assignRole('ketua rw');
        $rw->update($data);
        return back()->withSuccess('Ketua RW berhasil diupdate');
    }

    public function ketuaRWDelete(RW $rw)
    {
        $data= [
            'pemimpin' => null,
        ];
            $lama = User::where('id',$rw['pemimpin'])->first();
            $lama->removeRole('ketua rw');
        $rw->update($data);
        return back()->withSuccess('Ketua RW berhasil dihapus');
    }

    public function rt(RT $rt)
    {
        $data = [
            'lkd' => $rt,
            'link' => route('m.lkd.rt.pemimpin',$rt),
            'delete' => route('m.lkd.rt.pemimpin.hapus',$rt),
        ];
        return json_encode($data);
    }

    public function ketuaRT(Request $request, RT $rt)
    {
        $data = $request->validate([
			'pemimpin' => ['required','exists:users,id'],
            'user' =>[],            
		]);
        if($data['user']){
            $lama = User::where('id',$rt['pemimpin'])->first();
            $lama->removeRole('ketua rt');
        }
        $user = User::where('id',$data['pemimpin'])->first();
        $user->assignRole('ketua rt');
        $rt->update($data);
        return back()->withSuccess('Ketua RT berhasil diupdate');
    }

    public function ketuaRTDelete(RT $rt)
    {
        $data= [
            'pemimpin' => null,
        ];
            $lama = User::where('id',$rt['pemimpin'])->first();
            $lama->removeRole('ketua rt');
        $rt->update($data);
        return back()->withSuccess('Ketua RT berhasil dihapus');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Desa $desa)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDesaRequest $request,Desa $desa)
    {
        if($request->file('logo')){
            $logo = $request->file('logo');
            $filename = 'logo.png';
            $location = public_path('assets/img/icons/'.$filename);
            Image::make($logo)->resize(300, 300)->save($location);
        }
        if($request->file('icon')){
            $request->icon->move(public_path('assets/img/favicon/'), 'favicon.ico');
            File::copy(public_path('assets/img/favicon/favicon.ico'), public_path('favicon.ico'));
        }

        
        $desa->update([
            'alamat_kantor' => $request['alamat_kantor'],
            'email_desa' => $request['email_desa'],
            'no_telp' => $request['no_telp'],
        ]);
        if($desa->kode_wilayah != $request->kode_wilayah){
            $desa->update([
                'kode_wilayah' => $request['kode_wilayah'],
                'desa' => $request['desa'],
                'kecamatan' => $request['kecamatan'],
                'kabupaten' => Str::replace('Kab.', 'Kabupaten', $request['kabupaten']),
                'provinsi' => $request['provinsi'],
            ]);
            return redirect(route('admin.home'))->withSuccess('Konfigurasi berhasil diperbarui');
        }
        return back()->withSuccess('Profil desa berhasil diperbarui');
    }

    public function updateDesc(Request $request,Desa $desa)
    {
        $desa->update($request->only('deskripsi'));
        return back()->withSuccess('Deskripsi desa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Desa $desa)
    {
        //
    }
}
