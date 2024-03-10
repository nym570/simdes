<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Warga;

class WargaRT implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $warga = Warga::where('nik',$value)->where('rt_id',auth()->user()->warga->rt_id)->first();
        if (is_null($warga)) {
            $fail('NIK bukan warga RT anda');
        }
    }
}
