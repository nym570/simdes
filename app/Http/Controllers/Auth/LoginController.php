<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Role;

class LoginController extends Controller
{
	/**
	 * Display the login view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('auth.login',["title"=> 'Login Pengguna']);
	}

	/**
	 * Handle an incoming authentication request.
	 *
	 * @param  \App\Http\Requests\Auth\LoginRequest  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function store(LoginRequest $request)
	{
		$user = User::where('username',$request['username']) -> first();
		if($user){
			if($user['is_active']){
				$request->authenticate();
			$request->session()->regenerate();

			session()->flash('success', __('Selamat Datang ' . auth()->guard('web')->user()->warga->nama));
			activity()
				->causedBy($user)
				->log('login');
			return redirect()->intended(RouteServiceProvider::HOME);
			}
			return redirect()->route('login')
			->withError('Akun sudah tidak aktif');
			
			
		}
		else{
			return redirect()->route('login')
			->withError('Username pengguna tidak ditemukan');
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
		$user = Auth::guard('web')->user();
		Auth::guard('web')->logout();

		if(!Auth::guard('admin')->check()){
			$request->session()->invalidate();
			$request->session()->regenerateToken();
		}
		activity()
				->causedBy($user)
				->log('logout');

		return redirect('/login')->with('success', __('Anda berhasil keluar'));
	}
}
