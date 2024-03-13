<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warga;

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
}
