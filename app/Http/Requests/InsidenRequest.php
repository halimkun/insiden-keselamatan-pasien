<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InsidenRequest extends FormRequest
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
            'act'                     => 'nullable|string|in:tambah',

            'pasien_id'               => 'required_if:act,null|exists:pasien,id',

            'no_rekam_medis'          => 'required_if:act,tambah',
            'nama'                    => 'required_if:act,tambah|string|max:255',
            'jenis_kelamin'           => 'required_if:act,tambah|in:L,P',
            'tempat_lahir'            => 'required_if:act,tambah|string|max:255',
            'tanggal_lahir'           => 'required_if:act,tambah|date',
            'penanggung_biaya_id'     => 'required_if:act,tambah|exists:penanggung_biaya,id',

            'jenis_insiden_id'        => 'required|exists:jenis_insiden,id',
            'tgl_pasien_masuk'        => 'required|date',
            'tanggal_insiden'         => 'required|date',
            'waktu_insiden'           => 'required|date_format:H:i',
            'insiden'                 => 'required|string|max:255',
            'kronologi'               => 'required|string',
            'jenis_pelapor'           => 'required|string|max:255',
            'jenis_pelapor_lainnya'   => 'required_if:jenis_pelapor,lainnya|nullable|string|max:255',
            
            'korban_insiden'          => 'required|string|max:255',
            'korban_insiden_lainnya'  => 'required_if:korban_insiden,lainnya|nullable|string|max:255',
            
            'layanan_insiden'         => 'required|string|max:255',
            'layanan_insiden_lainnya' => 'required_if:layanan_insiden,lainnya|nullable|string|max:255',
            
            'kasus_insiden'           => 'required|array',                                       // Pastikan input berupa array
            'kasus_insiden.*'         => 'required|string|max:255',                              // Validasi setiap elemen array
            'kasus_insiden_lainnya'   => 'required_with:kasus_insiden.lainnya|nullable|string|max:255',
            
            'tempat_kejadian'         => 'required|string|max:255',
            'unit_id'                 => 'required|exists:unit,id',
            'dampak_insiden'          => 'required|string|max:255',
            
            'tindakan'                => 'required|string',
            'oleh'                    => 'required|string|in:dokter,perawat,bidan,tim,petugas',
            'oleh_tim'                => 'required_if:oleh,tim|nullable|string|max:255',
            'oleh_petugas'            => 'required_if:oleh,petugas|nullable|string|max:255',
            
            'pernah_terjadi'          => 'nullable|boolean',
            'status_pelapor'          => 'required|string|max:255',
            'grading_risiko'          => 'nullable|in:biru,hijau,kuning,merah',

            'rekomendasi'             => 'nullable',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'no_rekam_medis.required_if' => 'No. Rekam Medis wajib diisi jika tidak memilih pasien',
            'nama.required_if'           => 'Nama wajib diisi jika tidak memilih pasien',
            'jenis_kelamin.required_if'  => 'Jenis Kelamin wajib dipilih jika tidak memilih pasien',
            'tempat_lahir.required_if'   => 'Tempat Lahir wajib diisi jika tidak memilih pasien',
            'tanggal_lahir.required_if'  => 'Tanggal Lahir wajib diisi jika tidak memilih pasien',
        ];
    }

}
