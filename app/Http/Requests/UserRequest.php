<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
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
            'name'       => 'required|string',
            'username'   => 'required|string',
            'email'      => 'required|string|email',
            'no_hp'      => 'nullable|string|regex:/^[0-9]{10,15}$/',
            'jabatan'    => 'required|string',
            'unit'       => 'required|exists:unit,id',
            'departemen' => 'required|string',
        ];
    }
}
