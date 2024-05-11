<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\DataTables\MasterPanduanDataTable;
use App\DataTables\MasterAspirasiDataTable;
use App\DataTables\MasterInfoDataTable;

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
                echo "<option data-tokens='".$item->name."' value='".$item->id."'>".$item->name."</option>";
            }
        }
    }
    public function getInfo()
    {
        $data = DB::table('master_category_info')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->id."'>".$item->name."</option>";
            }
        }
    }
    public function indexPanduan(MasterPanduanDataTable $dataTable)
    {
        $title = 'Manajemen Master Kategori Panduan';
        $link = route('master.panduan.store');
        return $dataTable->render('admin.master',compact(['title','link']));
    }
    public function getPanduan()
    {
        $data = DB::table('master_category_panduan')->get();
        if($data){
            foreach($data as $item){
                echo "<option data-tokens='".$item->name."' value='".$item->id."'>".$item->name."</option>";
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
    public function editPanduan(Request $request,$id)
    {
        $data = DB::table('master_category_panduan')->where('id',$id)->value('name');
        $data = ['name' => $data, 'link' => route('master.panduan.update',$id)];

        return json_encode($data);
    }
    public function updatePanduan(Request $request, $id)
    {
        $validated =$request->validate([
			'name' => ['required','string'],
            
		]);
        DB::table('master_category_panduan')->where('id',$id)->update($validated);

        return back()->withSuccess('Kategori Berhasil diubah');
    }
    public function indexaspirasi(MasterAspirasiDataTable $dataTable)
    {
        $title = 'Manajemen Master Kategori Aspirasi';
        $link = route('master.aspirasi.store');
        return $dataTable->render('admin.master',compact(['title','link']));
    }

    public function storeaspirasi(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required','unique:master_category,name'],

		]);
        DB::insert('insert into master_category (name) values (?)', [$validateData['name']]);
        return back()->withSuccess('Kategori berhasil ditambahkan');
    }
    public function deleteaspirasi(Request $request,$id)
    {
        DB::delete('delete from master_category where id = (?)', [$id]);
        return back()->withSuccess('Kategori berhasil dihapus');
    }
    public function editaspirasi(Request $request,$id)
    {
        $data = DB::table('master_category')->where('id',$id)->value('name');
        $data = ['name' => $data, 'link' => route('master.aspirasi.update',$id)];

        return json_encode($data);
    }
    public function updateaspirasi(Request $request, $id)
    {
        $validated =$request->validate([
			'name' => ['required','string'],
            
		]);
        DB::table('master_category')->where('id',$id)->update($validated);

        return back()->withSuccess('Kategori Berhasil diubah');
    }


    public function indexinfo(MasterInfoDataTable $dataTable)
    {
        $title = 'Manajemen Master Kategori Info';
        $link = route('master.info.store');
        return $dataTable->render('admin.master',compact(['title','link']));
    }
   
    public function storeinfo(Request $request)
    {
        $validateData = $request->validate([
            'name' => ['required','unique:master_category_info,name'],

		]);
        DB::insert('insert into master_category_info (name) values (?)', [$validateData['name']]);
        return back()->withSuccess('Kategori berhasil ditambahkan');
    }
    public function deleteinfo(Request $request,$id)
    {
        DB::delete('delete from master_category_info where id = (?)', [$id]);
        return back()->withSuccess('Kategori berhasil dihapus');
    }
    public function editinfo(Request $request,$id)
    {
        $data = DB::table('master_category_info')->where('id',$id)->value('name');
        $data = ['name' => $data, 'link' => route('master.info.update',$id)];

        return json_encode($data);
    }
    public function updateinfo(Request $request, $id)
    {
        $validated =$request->validate([
			'name' => ['required','string'],
            
		]);
        DB::table('master_category_info')->where('id',$id)->update($validated);

        return back()->withSuccess('Kategori Berhasil diubah');
    }
    
}
