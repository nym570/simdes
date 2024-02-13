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
			'nama' => ['required','string'],
			'email' => ['required','string','email','unique:users,email'],
			'username' => ['required', 'string','unique:users,username'],
            'nik' => ['required', 'string','size:16'],
            'no_kk' => ['required', 'string','size:16'],
            'no_telp' => ['required', 'string','regex:/62[0-9]+$/u'],
			'password' => ['required', 'string','confirmed',Password::min(8)->letters()->numbers()],
		]);

		$validated['password'] = Hash::make($validated['password']);

		$user = User::create($validated);
		$user->assignRole('warga');
		$user->sendEmailVerificationNotification();

		return to_route('login')->withSuccess('Registrasi Berhasil');
		
	}
}
