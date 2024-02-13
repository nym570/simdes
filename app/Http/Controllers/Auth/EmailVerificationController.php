<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;

class EmailVerificationController extends Controller
{
	/**
	 * Create view
	 */
	public function create(Request $request)
	{
		return auth()->guard('web')->user()->hasVerifiedEmail()
			? redirect()->intended(RouteServiceProvider::HOME)
			: view('auth.email.verify-email',['title'=>'Verifikasi Email']);
	}

	/**
	 * Store
	 */
	public function store(Request $request)
	{
		if (auth()->guard('web')->user()->hasVerifiedEmail()) {
			return redirect()->intended(RouteServiceProvider::HOME);
		}

		auth()->guard('web')->user()->sendEmailVerificationNotification();

		return back()->with('success', __('Email verifikasi telah dikirimkan ke pengguna'));
	}
}
