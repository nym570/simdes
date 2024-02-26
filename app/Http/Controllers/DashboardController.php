<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin.verified')->only('config');
    }
    public function boot()
	{
        if(Auth::guard('admin')->check()){
            return redirect(route('admin.boot.config'));
        }
        else{
            return view('not-boot', ["title"=> 'Sistem belum dapat diakses']);
        }
	}
    public function config(){
        return view('boot', ["title"=> 'Konfigurasi Awal']);
    }
    public function index()
	{
        if(Auth::guest()){
            return view('home', ["title"=> 'Sistem Manajemen Desa']);
        }
        else{
            if(!auth()->guard('web')->user()->hasVerifiedEmail()){
                return redirect()->route('verification.notice');
            }
            return view('home', ["title"=> 'Dashboard']);
        }
		
	}
    
}
