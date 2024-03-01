<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class MasterController extends Controller
{
    public function getPekerjaan()
    {
        $data = DB::table('master_pekerjaan')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->name."'>".$item->name."</option>";
            }
        }
    }
    public function getPendidikan()
    {
        $data = DB::table('master_pendidikan')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->name."'>".$item->name."</option>";
            }
        }
    }
    public function getHubungan(Request $request)
    {
        
        if(isset($request['uncheck'])){
            $data = DB::table('master_hubungan')->whereNotIn('id', $request['uncheck'])->get();
        }
        else{
            $data = DB::table('master_hubungan')->get();
        }
        
        if($data){
            foreach($data as $item){
               
                    echo "<option data-tokens='".$item->name."' value='".$item->name."'>".$item->name."</option>";
                
                
            }
        }
    }
}
