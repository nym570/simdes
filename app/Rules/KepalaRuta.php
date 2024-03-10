<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\AnggotaRuta;

class KepalaRuta implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $kepala = AnggotaRuta::where('anggota_nik',$value)->where('hubungan','Kepala Keluarga')->first();
        if (is_null($kepala)) {
            $fail('NIK bukan kepala');
        }
    }
}
