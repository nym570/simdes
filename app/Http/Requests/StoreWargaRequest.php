<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWargaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
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
            'nik' => ['required', 'string','unique:warga,nik','size:16'],
            'no_kk' => ['required', 'string','size:16'],
            'nama' => ['required', 'string'],
            'tempat_lahir' =>  ['required', 'string'],
            'tanggal_lahir' =>  ['required', 'date'],
            'jenis_kelamin' => ['required', 'string'],
            'pendidikan' => ['required', 'string'],
            'pekerjaan' => ['required', 'string'],
            'agama' => ['required', 'string'],
            'gol_darah' => ['required', 'string'],
            'kode_wilayah_ktp' => ['required', 'string','regex:/[0-9]{2}.[0-9]{2}.[0-9]{4}/u'],
            'alamat_ktp' => ['required', 'string'],
             'no_telp' => ['required', 'string','regex:/62[0-9]+$/u'],
        ];
    }
}
