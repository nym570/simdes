<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\DataTables\MasterPanduanDataTable;

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
    public function getKategori()
    {
        $data = DB::table('master_category')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->name."'>".$item->name."</option>";
            }
        }
    }
    public function getInfo()
    {
        $data = DB::table('master_category_info')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->name."'>".$item->name."</option>";
            }
        }
    }
    public function indexPanduan(MasterPanduanDataTable $dataTable)
    {
        $title = 'Manajemen Panduan';
        $link = route('master.panduan.store');
        return $dataTable->render('admin.master',compact(['title','link']));
    }
    public function getPanduan()
    {
        $data = DB::table('master_category_panduan')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->name."'>".$item->name."</option>";
            }
        }
    }
    public function storePanduan(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required','unique:master_category_panduan,name'],

		]);
        DB::insert('insert into master_category_panduan (name) values (?)', [$validateData['name']]);
        return back()->withSuccess('Kategori berhasil ditambahkan');
    }
    public function deletePanduan(Request $request,$id)
    {
        DB::delete('delete from master_category_panduan where id = (?)', [$id]);
        return back()->withSuccess('Kategori berhasil dihapus');
    }
}
