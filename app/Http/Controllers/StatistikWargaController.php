<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warga;
use Jenssegers\Date\Date;

class StatistikWargaController extends Controller
{
    public function agama(){
        $title = 'Statistik Agama Warga Desa';
		$route = [
			'dusun' => route('statistik.warga.agama.dusun-count'),
			'rw' => route('statistik.warga.agama.rw-count'),
			'rt' => route('statistik.warga.agama.rt-count'),
		];
        
        return view('menu.guest.statistik.index', ["title"=> $title,"category"=>'Agama','route'=>$route]);
    }
    public function agamaDusun(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['id'])
		->selectRaw('warga.agama,count(*) as count')
		->groupBy('warga.agama')
		->get();
		}
		else{
			
        $chart = DB::table('warga')
		->where('status', 'warga')
		->selectRaw('warga.agama,count(*) as count')
		->groupBy('warga.agama')
		->get();
		}
		$name = $chart->map->agama->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function AgamaRW(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
		->where('rt.rw_id',$request['id'])
		->selectRaw('warga.agama,count(*) as count')
		->groupBy('warga.agama')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['dusun_id'])
		->selectRaw('warga.agama,count(*) as count')
		->groupBy('warga.agama')
		->get();
		}
		$name = $chart->map->agama->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function AgamaRT(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->where('status', 'warga')
		->where('rt_id',$request['id'])
		->selectRaw('warga.agama,count(*) as count')
		->groupBy('warga.agama')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
        ->where('rt.rw_id',$request['rw_id'])
		->selectRaw('warga.agama,count(*) as count')
		->groupBy('warga.agama')
		->get();
		}
		$name = $chart->map->agama->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}

	public function pendidikan(){
        $title = 'Statistik Pendidikan Warga Desa';
		$route = [
			'dusun' => route('statistik.warga.pendidikan.dusun-count'),
			'rw' => route('statistik.warga.pendidikan.rw-count'),
			'rt' => route('statistik.warga.pendidikan.rt-count'),
		];
        
        return view('menu.guest.statistik.index', ["title"=> $title,"category"=>'Pendidikan','route'=>$route]);
    }
    public function pendidikanDusun(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['id'])
		->selectRaw('warga.pendidikan,count(*) as count')
		->groupBy('warga.pendidikan')
		->get();
		}
		else{
			
        $chart = DB::table('warga')
		->where('status', 'warga')
		->selectRaw('warga.pendidikan,count(*) as count')
		->groupBy('warga.pendidikan')
		->get();
		}
		$name = $chart->map->pendidikan->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function pendidikanRW(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
		->where('rt.rw_id',$request['id'])
		->selectRaw('warga.pendidikan,count(*) as count')
		->groupBy('warga.pendidikan')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['dusun_id'])
		->selectRaw('warga.pendidikan,count(*) as count')
		->groupBy('warga.pendidikan')
		->get();
		}
		$name = $chart->map->pendidikan->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function pendidikanRT(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->where('status', 'warga')
		->where('rt_id',$request['id'])
		->selectRaw('warga.pendidikan,count(*) as count')
		->groupBy('warga.pendidikan')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
        ->where('rt.rw_id',$request['rw_id'])
		->selectRaw('warga.pendidikan,count(*) as count')
		->groupBy('warga.pendidikan')
		->get();
		}
		$name = $chart->map->pendidikan->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
	public function pekerjaan(){
        $title = 'Statistik Pekerjaan Warga Desa';
		$route = [
			'dusun' => route('statistik.warga.pekerjaan.dusun-count'),
			'rw' => route('statistik.warga.pekerjaan.rw-count'),
			'rt' => route('statistik.warga.pekerjaan.rt-count'),
		];
        
        return view('menu.guest.statistik.index', ["title"=> $title,"category"=>'Pekerjaan','route'=>$route]);
    }
	public function pekerjaanDusun(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['id'])
		->selectRaw('warga.pekerjaan,count(*) as count')
		->groupBy('warga.pekerjaan')
		->get();
		}
		else{
			
        $chart = DB::table('warga')
		->where('status', 'warga')
		->selectRaw('warga.pekerjaan,count(*) as count')
		->groupBy('warga.pekerjaan')
		->get();
		}
		$name = $chart->map->pekerjaan->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function pekerjaanRW(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
		->where('rt.rw_id',$request['id'])
		->selectRaw('warga.pekerjaan,count(*) as count')
		->groupBy('warga.pekerjaan')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['dusun_id'])
		->selectRaw('warga.pekerjaan,count(*) as count')
		->groupBy('warga.pekerjaan')
		->get();
		}
		$name = $chart->map->pekerjaan->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function pekerjaanRT(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->where('status', 'warga')
		->where('rt_id',$request['id'])
		->selectRaw('warga.pekerjaan,count(*) as count')
		->groupBy('warga.pekerjaan')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
        ->where('rt.rw_id',$request['rw_id'])
		->selectRaw('warga.pekerjaan,count(*) as count')
		->groupBy('warga.pekerjaan')
		->get();
		}
		$name = $chart->map->pekerjaan->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
	public function gol_darah(){
        $title = 'Statistik Golongan Darah Warga Desa';
		$route = [
			'dusun' => route('statistik.warga.gol_darah.dusun-count'),
			'rw' => route('statistik.warga.gol_darah.rw-count'),
			'rt' => route('statistik.warga.gol_darah.rt-count'),
		];
        
        return view('menu.guest.statistik.index', ["title"=> $title,"category"=>'Golongan Darah','route'=>$route]);
    }
	public function gol_darahDusun(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['id'])
		->selectRaw('warga.gol_darah,count(*) as count')
		->groupBy('warga.gol_darah')
		->get();
		}
		else{
			
        $chart = DB::table('warga')
		->where('status', 'warga')
		->selectRaw('warga.gol_darah,count(*) as count')
		->groupBy('warga.gol_darah')
		->get();
		}
		$name = $chart->map->gol_darah->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function gol_darahRW(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
		->where('rt.rw_id',$request['id'])
		->selectRaw('warga.gol_darah,count(*) as count')
		->groupBy('warga.gol_darah')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['dusun_id'])
		->selectRaw('warga.gol_darah,count(*) as count')
		->groupBy('warga.gol_darah')
		->get();
		}
		$name = $chart->map->gol_darah->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function gol_darahRT(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->where('status', 'warga')
		->where('rt_id',$request['id'])
		->selectRaw('warga.gol_darah,count(*) as count')
		->groupBy('warga.gol_darah')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
        ->where('rt.rw_id',$request['rw_id'])
		->selectRaw('warga.gol_darah,count(*) as count')
		->groupBy('warga.gol_darah')
		->get();
		}
		$name = $chart->map->gol_darah->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}

	public function jenis_kelamin(){
        $title = 'Statistik Jenis Kelamin Warga Desa';
		$route = [
			'dusun' => route('statistik.warga.jenis_kelamin.dusun-count'),
			'rw' => route('statistik.warga.jenis_kelamin.rw-count'),
			'rt' => route('statistik.warga.jenis_kelamin.rt-count'),
		];
        
        return view('menu.guest.statistik.index', ["title"=> $title,"category"=>'Jenis Kelamin','route'=>$route]);
    }
	public function jenis_kelaminDusun(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['id'])
		->selectRaw('warga.jenis_kelamin,count(*) as count')
		->groupBy('warga.jenis_kelamin')
		->get();
		}
		else{
			
        $chart = DB::table('warga')
		->where('status', 'warga')
		->selectRaw('warga.jenis_kelamin,count(*) as count')
		->groupBy('warga.jenis_kelamin')
		->get();
		}
		$name = $chart->map->jenis_kelamin->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function jenis_kelaminRW(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
		->where('rt.rw_id',$request['id'])
		->selectRaw('warga.jenis_kelamin,count(*) as count')
		->groupBy('warga.jenis_kelamin')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->join('rw', 'rw.id', '=', 'rt.rw_id')
		->where('status', 'warga')
        ->where('rw.dusun_id',$request['dusun_id'])
		->selectRaw('warga.jenis_kelamin,count(*) as count')
		->groupBy('warga.jenis_kelamin')
		->get();
		}
		$name = $chart->map->jenis_kelamin->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}
    public function jenis_kelaminRT(Request $request){
		if($request['id'] != 'all'){
			$chart = DB::table('warga')
		->where('status', 'warga')
		->where('rt_id',$request['id'])
		->selectRaw('warga.jenis_kelamin,count(*) as count')
		->groupBy('warga.jenis_kelamin')
		->get();
		}
		else{
			$chart = DB::table('warga')
		->join('rt', 'rt.id', '=', 'warga.rt_id')
		->where('status', 'warga')
        ->where('rt.rw_id',$request['rw_id'])
		->selectRaw('warga.jenis_kelamin,count(*) as count')
		->groupBy('warga.jenis_kelamin')
		->get();
		}
		$name = $chart->map->jenis_kelamin->toArray();
		$count = $chart->map->count->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
	}

	public function umur(){

		
        $title = 'Statistik Kelompok Umur Warga Desa';
		$route = [
			'dusun' => route('statistik.warga.umur.dusun-count'),
			'rw' => route('statistik.warga.umur.rw-count'),
			'rt' => route('statistik.warga.umur.rt-count'),
		];
        
        return view('menu.guest.statistik.index', ["title"=> $title,"category"=>'Kelompok Umur','route'=>$route]);
    }
	public function umurDusun(Request $request){
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
		if($request['id'] != 'all'){
			
			$chart = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
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
			})
			->mapToGroups(function ($item, $key) {
				return [$item->tanggal_lahir => $item];
			})
			->map(function ($group) {
				return count($group);
			})
			->sortKeys();
		}
		else{
			
			$chart = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->select('tanggal_lahir')
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
			})
			->mapToGroups(function ($item, $key) {
				return [$item->tanggal_lahir => $item];
			})
			->map(function ($group) {
				return count($group);
			})
			->sortKeys();
		}
		$name = $chart->keys()->toArray();
		$count = $chart->values()->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
		
	}
	public function umurRW(Request $request){
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
		if($request['id'] != 'all'){
			
			$chart = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('rt.rw_id',$request['id'])
			->get()
			->map(function ($item) use ($ranges) {
				$age =  Date::parse($item->tanggal_lahir)->diffInYears(Date::now());
				foreach($range as $key => $breakpoint)
				{
					if ($breakpoint <= $age)
					{
						$item->tanggal_lahir = $key;
						break;
					}
				}
				return $item;
			})
			->mapToGroups(function ($item, $key) {
				return [$item->tanggal_lahir => $item];
			})
			->map(function ($group) {
				return count($group);
			})
			->sortKeys();
		}
		else{
			
			$chart = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
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
			})
			->mapToGroups(function ($item, $key) {
				return [$item->tanggal_lahir => $item];
			})
			->map(function ($group) {
				return count($group);
			})
			->sortKeys();
		}
		$name = $chart->keys()->toArray();
		$count = $chart->values()->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
		
	}
	public function umurRT(Request $request){
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
		if($request['id'] != 'all'){
			
			$chart = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
			->where('rt_id',$request['id'])
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
			})
			->mapToGroups(function ($item, $key) {
				return [$item->tanggal_lahir => $item];
			})
			->map(function ($group) {
				return count($group);
			})
			->sortKeys();
		}
		else{
			
			$chart = DB::table('warga')
			->join('rt', 'rt.id', '=', 'warga.rt_id')
			->join('rw', 'rw.id', '=', 'rt.rw_id')
			->where('status', 'warga')
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
			})
			->mapToGroups(function ($item, $key) {
				return [$item->tanggal_lahir => $item];
			})
			->map(function ($group) {
				return count($group);
			})
			->sortKeys();
		}
		$name = $chart->keys()->toArray();
		$count = $chart->values()->toArray();
		$grafik = [
			'label' => $name,
			'data' => $count
		];
		return json_encode($grafik);
	
		
		
	}
}
