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
use Illuminate\Support\Facades\DB;

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
            'kedatangan' => Dinamika::whereHasMorph( 'dinamika', [Kedatangan::class])->count(),
            'kematian' => $kematian->count(),
            'kepindahan' => Dinamika::whereHasMorph( 'dinamika', [Kepindahan::class])->count(),
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

    public function rwCount(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
		->where('rt.rw_id',$request['id'])
		->selectRaw('rt.name,count(*) as count')
		->groupBy('rt.name')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('rw.dusun_id',$request['dusun_id'])
		->where('status', 'warga')
		->selectRaw('rw.name,count(*) as count')
		->groupBy('rw.name')
		->get();
		}
		$name = $chart->map->name->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
	public function dusunCount(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
		->where('rw.dusun_id',$request['id'])
		->selectRaw('rw.name,count(*) as count')
		->groupBy('rw.name')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->join('dusun', 'dusun.id', '=', 'rw.dusun_id')
		->where('status', 'warga')
		->selectRaw('dusun.name,count(*) as count')
		->groupBy('dusun.name')
		->get();
		}
		$name = $chart->map->name->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    
}
