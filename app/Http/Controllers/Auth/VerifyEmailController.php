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
		
		if($request->user()->hasVerifiedEmail()){
			return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
		}
		else{
			$request->user()->markEmailAsVerified();
			event(new Verified($request->user()));
			session()->flash('success', __('Akun berhasil di aktivasi'));
				return redirect()->intended(RouteServiceProvider::HOME . '?verified=1');
		}


		
	}
}
