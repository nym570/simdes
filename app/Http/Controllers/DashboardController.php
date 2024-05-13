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
use App\DataTables\DusunBootDataTable;
use App\DataTables\RWBootDataTable;
use App\DataTables\RTBootDataTable;
use Jenssegers\Date\Date;
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
    public function config(DusunBootDataTable $dusunDT, RWBootDataTable $rwDT, RTBootDataTable $rtDT){
        return view('boot', ["title"=> 'Konfigurasi Awal','dusunDT' => $dusunDT->html(),
		'rwDT' => $rwDT->html(),
		'rtDT' => $rtDT->html(),]);
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

	public function getDusun(DusunBootDataTable $dusunDT)
    {
        return $dusunDT->render('boot');
    }

    public function getRW(RWBootDataTable $rwDT)
    {
        return $rwDT->render('boot');
    }

    public function getRT(RTBootDataTable $rtDT)
    {
        return $rtDT->render('boot');
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

	public function pyramidDusun(Request $request){
		$ranges = [ // the start of each age-range.
			'70+' => 70,
			'65-69' => 65,
			'60-64' => 60,
			'55-59' => 55,
			'50-54' => 50,
			'45-49' => 45,
			'40-44' => 40,
			'35-39' => 35,
			'30-34' => 30,
			'25-29' => 25,
			'20-24' => 20,
			'15-19' => 15,
			'10-14' => 10,
			'05-09' => 5,
			'00-04' => 0,

		];
		$lkCount= [ // the start of each age-range.
			'70+' => 0,
			'65-69' => 0,
			'60-64' => 0,
			'55-59' => 0,
			'50-54' => 0,
			'45-49' => 0,
			'40-44' => 0,
			'35-39' => 0,
			'30-34' => 0,
			'25-29' => 0,
			'20-24' => 0,
			'15-19' => 0,
			'10-14' => 0,
			'05-09' => 0,
			'00-04' => 0,

		];
		
		$prCount= [ // the start of each age-range.
			'70+' => 0,
			'65-69' => 0,
			'60-64' => 0,
			'55-59' => 0,
			'50-54' => 0,
			'45-49' => 0,
			'40-44' => 0,
			'35-39' => 0,
			'30-34' => 0,
			'25-29' => 0,
			'20-24' => 0,
			'15-19' => 0,
			'10-14' => 0,
			'05-09' => 0,
			'00-04' => 0,

		];
		if($request['id'] != 'all'){
			
			$laki = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin', 'laki-laki')
			->where('rw.dusun_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($laki as $item){
				$lkCount[$item->tanggal_lahir] +=1;
			}
			$pr = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin', 'perempuan')
			->where('rw.dusun_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($pr as $item){
				$prCount[$item->tanggal_lahir] -=1;
			}
		}
		else{
			
			$laki= DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin','laki-laki')
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($laki as $item){
				$lkCount[$item->tanggal_lahir] +=1;
			}
			
			$pr= DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin','perempuan')
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir= $key;
						break;
					}
				}
				return $item;
			});
			foreach($pr as $item){
				$prCount[$item->tanggal_lahir] -=1;
			}
		}
		$grafik = [
			'laki' => array_values($lkCount),
			'perempuan' => array_values($prCount),
		];
		return json_encode($grafik);
	
	
		
	}
    public function pyramidRW(Request $request){
		$ranges = [ // the start of each age-range.
			'70+' => 70,
			'65-69' => 65,
			'60-64' => 60,
			'55-59' => 55,
			'50-54' => 50,
			'45-49' => 45,
			'40-44' => 40,
			'35-39' => 35,
			'30-34' => 30,
			'25-29' => 25,
			'20-24' => 20,
			'15-19' => 15,
			'10-14' => 10,
			'05-09' => 5,
			'00-04' => 0,

		];
		$lkCount= [ // the start of each age-range.
			'70+' => 0,
			'65-69' => 0,
			'60-64' => 0,
			'55-59' => 0,
			'50-54' => 0,
			'45-49' => 0,
			'40-44' => 0,
			'35-39' => 0,
			'30-34' => 0,
			'25-29' => 0,
			'20-24' => 0,
			'15-19' => 0,
			'10-14' => 0,
			'05-09' => 0,
			'00-04' => 0,

		];
		
		$prCount= [ // the start of each age-range.
			'70+' => 0,
			'65-69' => 0,
			'60-64' => 0,
			'55-59' => 0,
			'50-54' => 0,
			'45-49' => 0,
			'40-44' => 0,
			'35-39' => 0,
			'30-34' => 0,
			'25-29' => 0,
			'20-24' => 0,
			'15-19' => 0,
			'10-14' => 0,
			'05-09' => 0,
			'00-04' => 0,

		];
		if($request['id'] != 'all'){
			
			$laki = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin','laki-laki')
			->where('rt.rw_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($laki as $item){
				$lkCount[$item->tanggal_lahir] +=1;
			}
			$pr = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin','perempuan')
			->where('rt.rw_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($pr as $item){
				$prCount[$item->tanggal_lahir] -=1;
			}
		}
		else{
			
			$laki= DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin', 'laki-laki')
			->where('rw.dusun_id',$request['dusun_id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($laki as $item){
				$lkCount[$item->tanggal_lahir] +=1;
			}
			
			$pr= DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin', 'perempuan')
			->where('rw.dusun_id',$request['dusun_id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir= $key;
						break;
					}
				}
				return $item;
			});
			foreach($pr as $item){
				$prCount[$item->tanggal_lahir] -=1;
			}
		}
		$grafik = [
			'laki' => array_values($lkCount),
			'perempuan' => array_values($prCount),
		];
		return json_encode($grafik);
	
	
		
	}
	public function pyramidRT(Request $request){
		$ranges = [ // the start of each age-range.
			'70+' => 70,
			'65-69' => 65,
			'60-64' => 60,
			'55-59' => 55,
			'50-54' => 50,
			'45-49' => 45,
			'40-44' => 40,
			'35-39' => 35,
			'30-34' => 30,
			'25-29' => 25,
			'20-24' => 20,
			'15-19' => 15,
			'10-14' => 10,
			'05-09' => 5,
			'00-04' => 0,

		];
		$lkCount= [ // the start of each age-range.
			'70+' => 0,
			'65-69' => 0,
			'60-64' => 0,
			'55-59' => 0,
			'50-54' => 0,
			'45-49' => 0,
			'40-44' => 0,
			'35-39' => 0,
			'30-34' => 0,
			'25-29' => 0,
			'20-24' => 0,
			'15-19' => 0,
			'10-14' => 0,
			'05-09' => 0,
			'00-04' => 0,

		];
		
		$prCount= [ // the start of each age-range.
			'70+' => 0,
			'65-69' => 0,
			'60-64' => 0,
			'55-59' => 0,
			'50-54' => 0,
			'45-49' => 0,
			'40-44' => 0,
			'35-39' => 0,
			'30-34' => 0,
			'25-29' => 0,
			'20-24' => 0,
			'15-19' => 0,
			'10-14' => 0,
			'05-09' => 0,
			'00-04' => 0,

		];
		if($request['id'] != 'all'){
			
			$laki = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin','laki-laki')
			->where('rt_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($laki as $item){
				$lkCount[$item->tanggal_lahir] +=1;
			}
			$pr = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin','perempuan')
			->where('rt_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($pr as $item){
				$prCount[$item->tanggal_lahir] -=1;
			}
		}
		else{
			
			$laki= DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin', 'laki-laki')
			->where('rt.rw_id',$request['rw_id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			});
			foreach($laki as $item){
				$lkCount[$item->tanggal_lahir] +=1;
			}
			
			$pr= DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('jenis_kelamin', 'perempuan')
			->where('rt.rw_id',$request['rw_id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($ranges as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir= $key;
						break;
					}
				}
				return $item;
			});
			foreach($pr as $item){
				$prCount[$item->tanggal_lahir] -=1;
			}
		}
		$grafik = [
			'laki' => array_values($lkCount),
			'perempuan' => array_values($prCount),
		];
		return json_encode($grafik);
	
	
		
	}
}
