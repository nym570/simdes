<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;

class VerifyEmailController extends Controller
{
	/**
	 * Handle the incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */

	public function __invoke(EmailVerificationRequest $request)
	{
		
		if(->hasVerifiedEmail()){
			return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
		}
		else{
			$user->markEmailAsVerified();
			event(new Verified($user));
			session()->flash('success', __('Akun berhasil di aktivasi'));
			if ($user->hasRole('admin')) {
				return redirect()->intended(RouteServiceProvider::ADMIN_HOME . '?verified=1');
			}
			else {
				return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
			}
		}


		
	}
}
