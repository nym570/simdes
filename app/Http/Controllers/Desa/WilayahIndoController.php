<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class WilayahIndoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getProv()
    {
        $response =  Http::get('https://api.cahyadsn.com/provinces');
        if($response->successful()){
            $data = $response['data'];
            foreach($data as $item){
                echo "<option data-tokens='".$item['kode'].$item['nama']."' value='".$item['kode']."'>".Str::title($item['nama'])."</option>";
            }
        }
    }
     public function getKab(Request $request)
    {
        $id = $request['id_prov'];
        $response =  Http::get('https://api.cahyadsn.com/regencies/'.$id);
        if($response->successful()){
            $data = $response['data'];
            foreach($data as $item){
                echo "<option data-tokens='".$item['kode'].$item['nama']."' value='".$item['kode']."'>".Str::title($item['nama'])."</option>";
            }
        }
    }

    public function getKec(Request $request)
    {
        $id = $request['id_kab'];
        $response =  Http::get('https://api.cahyadsn.com/districts/'.$id);
        if($response->successful()){
            $data = $response['data'];
            foreach($data as $item){
                echo "<option data-tokens='".$item['kode'].$item['nama']."' value='".$item['kode']."'>".Str::title($item['nama'])."</option>";
            }
        }
    }

    public function getDes(Request $request)
    {
        $id = $request['id_kec'];
        $response =  Http::get('https://api.cahyadsn.com/villages/'.$id);
        if($response->successful()){
            $data = $response['data'];
            foreach($data as $item){
                echo "<option data-tokens='".$item['kode'].$item['nama']."' value='".$item['kode']."'>".Str::title($item['nama'])."</option>";
            }
        }
    }
    
     public function index()
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
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
