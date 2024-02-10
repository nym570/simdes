<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
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
