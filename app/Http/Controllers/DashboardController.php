<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Warga;
use App\Models\Ruta;
use App\Models\Kelahiran;
use App\Models\Kematian;
use App\Models\Kedatangan;
use App\Models\Kepindahan;
use App\Models\Dinamika;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.verified')->only('config');
    }
    public function boot()
	{
        if(Auth::guard('admin')->check()){
            return redirect(route('admin.boot.config'));
        }
        else{
            return view('not-boot', ["title"=> 'Sistem belum dapat diakses']);
        }
	}
    public function config(){
        return view('boot', ["title"=> 'Konfigurasi Awal']);
    }
    public function index()
	{
        if(auth()->user()){
            if(!auth()->user()->hasVerifiedEmail()){
                return redirect(route('verification.notice'));
            }
        }
        $title = 'Dashboard';
        $kelahiran = Kelahiran::whereYear('waktu',now()->year)->where('verifikasi',1);
        $kedatangan = Kedatangan::whereYear('waktu',now()->year)->where('verifikasi',1);
        $kematian = Kematian::whereYear('waktu',now()->year)->where('verifikasi',1);
        $kepindahan = Kepindahan::whereYear('waktu',now()->year)->where('verifikasi',1);
        $warga = Warga::groupby('status')->whereIn('status',['warga','sementara tidak berdomisili'])->selectRaw('count(*) as total, status')->pluck('total','status')->all();
        $ktp = Warga::selectRaw('count(*) as count, ktp_desa')->groupby('ktp_desa')->get();
        $ruta = Ruta::count();
        $data = [
            'kelahiran' => $kelahiran->count(),
            'kedatangan' => $kedatangan->count(),
            'kematian' => $kematian->count(),
            'kepindahan' => $kepindahan->count(),
            'warga' => [
                'status' => $warga,
                'graph' => [
                    'label' => ['desa','luar desa'],
					'data' => $ktp->map->count->toArray()
                ]
            ],
            'ruta' => $ruta

        ];
        if(Auth::guest()){
            $title = 'Sistem Manajemen Desa';
        }
        return view('home', ["title"=> $title,"data" => $data]);
		
	}
    
}
