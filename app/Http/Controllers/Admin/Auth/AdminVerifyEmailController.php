<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use App\Http\Requests\AdminEmailVerificationRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class AdminVerifyEmailController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function __invoke(AdminEmailVerificationRequest $request)
	{
		if (auth()->guard('admin')->user()->hasVerifiedEmail()) {
			return redirect()->intended(RouteServiceProvider::ADMIN_HOME . '?verified=1');
		}
			auth()->guard('admin')->user()->markEmailAsVerified();
			event(new Verified(auth()->guard('admin')->user()));
			session()->flash('success', __('Akun berhasil di aktivasi'));
			return redirect()->intended(RouteServiceProvider::ADMIN_HOME . '?verified=1');


		
	}
}
