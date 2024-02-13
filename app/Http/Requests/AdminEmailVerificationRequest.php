<?php

namespace App\Http\Requests;

use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class AdminEmailVerificationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!auth()->guard('admin')->check()){
            return false;
        }
        if (! (hash_equals((string) auth()->guard('admin')->user()->getKey(), (string) $this->route('id')))) {
            
            return false;
        }

        if (! (hash_equals(sha1(auth()->guard('admin')->user()->getEmailForVerification()), (string) $this->route('hash')))) {
            return false;
        }
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /**
     * Fulfill the email verification request.
     *
     * @return void
     */
    public function fulfill()
    {
        if (! auth()->guard('admin')->user()->hasVerifiedEmail()) {
            auth()->guard('admin')->user()->markEmailAsVerified();

            event(new Verified($this->user()));
        }
        else if(!auth()->guard('admin')->user()->hasVerifiedEmail()){
            auth()->guard('admin')->user()->markEmailAsVerified();

            event(new Verified(auth()->guard('admin')->user()));
        }
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return \Illuminate\Validation\Validator
     */
    public function withValidator(Validator $validator)
    {
        return $validator;
    }
}
