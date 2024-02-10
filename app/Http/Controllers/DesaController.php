<?php

namespace App\Http\Controllers;

use App\Models\Desa;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;
use App\Models\User;
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
        return view('admin.desa.desa',compact('title'));
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
			'name' => ['required','string'],
			'nama_kepala_dusun' => ['required','string'],
		]);
        $role = Role::create(['name' => $request->name,'category'=>'kepala dusun']);
        $data['kepala_dusun'] = $role->id;
        $dusun = Dusun::create($data);
        
        return back()->withSuccess('Dusun berhasil ditambahkan');
    }
    public function storeRW(Request $request)
    {
        $data = $request->validate([
			'name' => ['required','integer'],
			'nama_ketua_rw' => ['required','string'],
            'dusun_id' => ['required']
		]);
        $data['name'] = 'RW '.str_pad($data['name'], 2, '0', STR_PAD_LEFT);
        
        $role = Role::create(['name' => $data['name'],'category'=>'ketua RW']);
        $data['ketua_rw'] = $role->id;
        RW::create($data);
        
        return back()->withSuccess('RW berhasil ditambahkan');
    }

    public function storeRT(Request $request)
    {
        $data = $request->validate([
			'name' => ['required','integer'],
			'nama_ketua_rt' => ['required','string'],
            'rw_id' => ['required']
		]);
        $rw = RW::where('id',$data['rw_id'])->first();
        $data['name'] = $rw->name.'/RT '.str_pad($data['name'], 2, '0', STR_PAD_LEFT);
        
        $role = Role::create(['name' => $data['name'],'category'=>'ketua RT']);
        $data['ketua_rt'] = $role->id;
        RT::create($data);
        
        return back()->withSuccess('RT berhasil ditambahkan');
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
    public function store(StoreDesaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Desa $desa)
    {
        //
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

        if($desa->kode_wilayah != $request->kode_wilayah){
            $desa->update([
                'kode_wilayah' => $request['kode_wilayah'],
                'desa' => $request['desa'],
                'kecamatan' => $request['kecamatan'],
                'kabupaten' => $request['kabupaten'],
                'provinsi' => $request['provinsi'],
            ]);
        }
        $desa->update([
            'alamat_kantor' => $request['alamat_kantor'],
            'email_desa' => $request['email_desa'],
            'no_telp' => $request['no_telp'],
        ]);
        return back()->withSuccess('Profil desa berhasil diperbarui');
    }

    public function updateDesc(Request $request,Desa $desa)
    {
        $data = $request->validate([
			'deskripsi' => ['string'],
		]);
       
        $desa->update($data);
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
