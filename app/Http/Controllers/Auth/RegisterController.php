<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;
use App\Rules\ValidateKK;
use App\Rules\NIKExist;
use App\Notifications\PasswordSend;
use Illuminate\Support\Facades\Notification;

class RegisterController extends Controller
{
	/**
	 * Display the registration view.
	 *
	 * @return \Illuminate\View\View
	 */
	public function create()
	{
		return view('auth.register', ['title'=>'Buat Akun']);
	}

	/**
	 * Handle an incoming registration request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\RedirectResponse
	 *
	 * @throws \Illuminate\Validation\ValidationException
	 */
	public function store(Request $request)
	{
		
		$request['username'] = $request['nik'];
		$validated = $request->validate([
			'email' => ['required','string','email','unique:users,email'],
			'username' => ['required', 'string','unique:users,username'],
            'nik' => ['required', 'string','size:16','unique:users,nik',new NIKExist],
            'no_kk' => ['required', 'string','size:16',new ValidateKK($request['nik'])],
			'password' => ['required', 'string','confirmed',Password::min(8)->letters()->numbers()],
		]);

		$validated['password'] = Hash::make($validated['password']);

		$user = User::create($validated);
		$user->assignRole('warga');
		$user->sendEmailVerificationNotification();
		Notification::send($user, new PasswordSend($request['password'],route('login')));

		return to_route('login')->withSuccess('Registrasi Berhasil, silahkan cek email anda untuk konfirmasi email');
		
	}
}
