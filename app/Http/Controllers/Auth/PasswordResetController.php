<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use App\Models\User;
use Illuminate\Validation\Rules\Password as Pswd;
use Spatie\Permission\Models\Role;

class PasswordResetController extends Controller
{
	/**
	 * Display the password reset view.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\View\View
	 */
	public function create(Request $request)
	{
		return view('auth.password.reset-password', ['request' => $request,'title'=>'Ubah password']);
	}

	/**
	 * Handle an incoming new password request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		$request->validate([
			'token' => ['required'],
			'email' => ['required', 'email'],
			'password' => ['required', 'confirmed', Pswd::min(8)->letters()->numbers()],
		]);

		// Here we will attempt to reset the user's password. If it is successful we
		// will update the password on an actual user model and persist it to the
		// database. Otherwise we will parse the error and return the response.
		$status = Password::reset(
			$request->only('email', 'password', 'password_confirmation', 'token'),
			function ($user) use ($request) {
				$user->forceFill([
					'password' => Hash::make($request->password),
					'remember_token' => Str::random(60),
				])->save();

				event(new PasswordReset($user));
				Notification::send($user, new PasswordSend($request->password,route('login')));
			}
		);

		// If the password was successfully reset, we will redirect the user back to
		// the application's home authenticated view. If there is an error we can
		// redirect them back to where they came from with their error message.
		return $status == Password::PASSWORD_RESET
			? redirect()->route('login')->with('success', __($status))
			: back()->withInput($request->only('email'))
			->withErrors(['email' => __($status)]);
	}
}
