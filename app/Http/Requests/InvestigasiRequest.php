<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvestigasiRequest extends FormRequest
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
            'penyebab_langsung'  => 'required|string',
            'penyebab_awal'      => 'required|string',
            'tanggal_mulai'      => 'required|date',
            'tanggal_selesai'    => 'required|date',
            'tanggal_pengesahan' => 'required|date',
            'lengkap'            => 'required|boolean',
            'lanjutan'           => 'required|boolean',
            'grading'            => 'required|in:biru,hijau,kuning,merah',
        ];
    }
}
