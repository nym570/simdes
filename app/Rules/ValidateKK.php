<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use App\Models\Warga;

class ValidateKK implements ValidationRule
{
    private $nik;

    public function __construct($nik)
    {
        $this->nik = $nik;
    }
    
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
         $warga = Warga::where('nik',$this->nik)->first();
        if ($warga['no_kk']!=$value) {
            $fail('No KK berbeda dengan data KK warga');
        }
    }
}
