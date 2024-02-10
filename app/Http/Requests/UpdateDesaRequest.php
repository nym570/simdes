<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\CheckIfFavicon;

class UpdateDesaRequest extends FormRequest
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
            'kode_wilayah' => ['string'],
            'alamat_kantor' => [ 'string'],
            'email_desa' => ['string','email'],
            'no_telp' => [ 'string','regex:/62[0-9]+$/u'],
            'logo' => [ 'mimes:jpg,png','max:1024'],
            'icon' => [ new CheckIfFavicon,'max:500'],
        ];
    }
}
