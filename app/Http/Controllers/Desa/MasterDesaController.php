<?php

namespace App\Http\Controllers\Desa;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Dusun;
use App\Models\RW;
use App\Models\RT;

class MasterDesaController extends Controller
{
    public function getDusun()
    {
        
        $data = Dusun::all();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item['name']."' value='".$item['id']."'>".$item['name']."</option>";
            }
        }
        
    }
     public function getRW(Request $request)
    {
        if($request->has('id')){
            $id = $request['id'];
            $data = RW::where('dusun_id',$id)->get();
        }
        else{
            $data = RW::all();
        }
       
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item['name']."' value='".$item['id']."'>".$item['name']."</option>";
            }
        }
    }
    public function getRT(Request $request)
    {
        if($request->has('id')){
            $id = $request['id'];
            $data = RT::where('rw_id',$id)->get();
        }
        else{
            $data = RT::all();
        }
        
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item['name']."' value='".$item['id']."'>".$item['name']."</option>";
            }
        }
    }
}
