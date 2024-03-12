<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Warga;

class StatistikController extends Controller
{
    public function agama(){
        $title = 'Kependudukan Berdasarkan Agama';
        
        return view('menu.guest.statistik.index', ["title"=> $title]);
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
}
