<?php

namespace App\Http\Controllers\Layanan;

use App\Models\Aspirasi;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\DataTables\AspirasiDataTable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;


class AspirasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AspirasiDataTable $dataTable)
    {
        $title = 'Manajemen Aspirasi';
        $cakupan = auth()->user()->getRoleNames()->toArray(); 
        if(in_array('bpd',$cakupan)){
            $data = Aspirasi::select('is_open', DB::raw('count(*) as total'))->whereYear('created_at', date('Y'))->groupBy('is_open')->pluck('total','is_open')->all();
        }
        if(in_array('kepala desa',$cakupan)){
            $data = Aspirasi::select('is_open', DB::raw('count(*) as total'))->where('tingkat','desa')->whereYear('created_at', date('Y'))->groupBy('is_open')->pluck('total','is_open')->all();
        }
            else if(in_array('kepala dusun',$cakupan)){
                $data = Aspirasi::select('is_open', DB::raw('count(*) as total'))->whereYear('created_at', date('Y'))->where('tingkat','dusun')->whereHas("user.warga.rt.rw.dusun", function(Builder $builder) {
                     $builder->where('pemimpin', '=', auth()->user()->id);
                 })->groupBy('is_open')->pluck('total','is_open')->all();
                
            }
            else if(in_array('ketua rw',$cakupan)){
                $data = Aspirasi::select('is_open', DB::raw('count(*) as total'))->whereYear('created_at', date('Y'))->where('tingkat','rw')->whereHas("user.warga.rt.rw", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                })->groupBy('is_open')->pluck('total','is_open')->all();
                
            }
            else if(in_array('ketua rt',$cakupan)){
                $data = Aspirasi::select('is_open', DB::raw('count(*) as total'))->whereYear('created_at', date('Y'))->where('tingkat','rt')->whereHas("user.warga.rt", function(Builder $builder) {
                    $builder->where('pemimpin', '=', auth()->user()->id);
                })->groupBy('is_open')->pluck('total','is_open')->all();
                
            }
        
        return $dataTable->render('menu.aspirasi.index',compact(['title','data']));
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Aspirasi $aspirasi)
    {
        $title = $aspirasi->judul;
        return view('menu.aspirasi.show',compact(['title','aspirasi']));
    }

    public function status(Aspirasi $aspirasi)
    {
        $data['is_open'] = false;
		if(!$aspirasi->is_open){
			$data['is_open'] = true;
		}
		$aspirasi->update($data);

		return back()->withSuccess('Status aspirasi berhasil diubah');
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Aspirasi $aspirasi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Aspirasi $aspirasi)
    {
        //
    }
}
