<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Validation\Rules\Password;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'nama' => ['required','string'],
			'email' => ['required','string','email','unique:users,email'],
			'username' => ['required', 'string','unique:users,username'],
            'nik' => ['required', 'string','size:16'],
            'no_kk' => ['required', 'string','size:16'],
            'no_telp' => ['required', 'string','regex:/62[0-9]+$/u'],
			'password' => ['required', 'string','confirmed',Password::min(8)->letters()->numbers()],
		];
    }
}
