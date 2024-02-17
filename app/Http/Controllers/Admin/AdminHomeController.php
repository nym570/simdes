<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Desa;

class AdminHomeController extends Controller
{
    public function index()
	{
		$desa = Desa::get()->first();
		if(is_null($desa->kode_wilayah)){
			return  redirect(route('admin.boot'));
        }
		return view('admin.home', ["title"=> 'Dashboard Admin']);
	}
}
