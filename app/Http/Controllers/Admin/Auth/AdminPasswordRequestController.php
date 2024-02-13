<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Admin;
use Spatie\Permission\Models\Role;

class AdminPasswordRequestController extends Controller
{
	/**
	 * Display the password reset link request view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('admin.auth.password.forgot-password');
	}

	/**
	 * Handle an incoming password reset link request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		
		$request->validate([
			'username' => ['required'],
			'email' => ['required', 'email'],
		]);
		
		$user = Admin::query()->where('username', $request->input('username'))->where('email', $request->input('email')) ->get()->first();
		if(is_null($user)){
			return back()->with('error', __('kombinasi username dan email tidak ditemukan'))->withInput($request->only('email','username'));
		}
		if(!$user->hasRole('admin')){
			return back()->with('error', __('akun anda bukan merupakan admin'))->withInput($request->only('email','username'));
		}

		
		// We will send the password reset link to this user. Once we have attempted
		// to send the link, we will examine the response then see the message we
		// need to show to the user. Finally, we'll send out a proper response.

		
		$status = Password::broker('admin')->sendResetLink(
			$request->only('email')
		);

		return $status == Password::RESET_LINK_SENT
			? back()->with('success', __($status))
			: back()->withInput($request->only('email'))
			->withErrors(['email' => __($status)]);
	}
}
