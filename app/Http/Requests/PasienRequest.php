<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasienRequest extends FormRequest
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
			'nama'                => 'required|string',
            'no_rekam_medis'      => 'required|numeric|digits_between:8,11',
			'tanggal_lahir'       => 'required',
			'jenis_kelamin'       => 'required',
			'alamat'              => 'string',
			'penanggung_biaya_id' => 'required',
        ];
    }
}
