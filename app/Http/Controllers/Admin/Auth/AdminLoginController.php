<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\AdminLoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;

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
		$request->authenticate();
		

		$request->session()->regenerate();

		session()->flash('success', __('Selamat Datang ' . request()->user()->name));
		return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
	}

	/**
	 * Destroy an authenticated session.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function logout(Request $request)
	{
		Auth::guard('web')->logout();

		$request->session()->invalidate();

		$request->session()->regenerateToken();

		return redirect('/admin/login')->with('success', __('Anda telah berhasil keluar'));
	}
}
