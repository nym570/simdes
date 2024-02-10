<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminLoginController extends Controller
{
	/**
	 * Display the login view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('admin.auth.login');
	}

	/**
	 * Handle an incoming authentication request.
	 *
	 * @param  \App\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(AdminLoginRequest $request)
	{
		$user = Admin::where('username',$request['username']) -> first();
		if($user->hasRole('admin')){
			$request->authenticate();
			$request->session()->regenerate();

			session()->flash('success', __('Selamat Datang ' . auth()->guard('admin')->user()->nama));
			return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
			
		}
		else{
			return redirect()->route('admin.login')
			->withError('Username yang anda masukkan bukan admin');
		}
		
		
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout(Request $request)
	{
		Auth::guard('admin')->logout();
		if(!Auth::guard('web')->check()){
			$request->session()->invalidate();
			$request->session()->regenerateToken();
		}

		

		return redirect('/admin/login')->with('success', __('Anda telah berhasil keluar'));
	}
}
