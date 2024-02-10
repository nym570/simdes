<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class AdminEmailVerificationController extends Controller
{
	/**
	 * Create view
	 */
	public function create(Request $request)
	{
		return auth()->guard('admin')->user()->hasVerifiedEmail()
			? redirect()->intended(RouteServiceProvider::ADMIN_HOME)
			: view('admin.auth.email.verify-email');
	}

	/**
	 * Store
	 */
	public function store(Request $request)
	{
		if (auth()->guard('admin')->user()->hasVerifiedEmail()) {
			return redirect()->intended(RouteServiceProvider::ADMIN_HOME);
		}

		auth()->guard('admin')->user()->sendEmailVerificationNotification();

		return back()->with('success', __('Email verifikasi berhasil terkirim'));
	}
}
