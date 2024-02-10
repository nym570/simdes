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
		return $request->user()->hasVerifiedEmail()
			? redirect()->intended(RouteServiceProvider::HOME)
			: view('auth.email.verify-email');
	}

	/**
	 * Store
	 */
	public function store(Request $request)
	{
		if ($request->user()->hasVerifiedEmail()) {
			return redirect()->intended(RouteServiceProvider::HOME);
		}

		$request->user()->sendEmailVerificationNotification();

		return back()->with('success', __('Email verifikasi telah dikirimkan ke pengguna'));
	}
}
