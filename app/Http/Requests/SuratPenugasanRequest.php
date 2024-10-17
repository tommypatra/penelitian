<?php

namespace App\Http\Requests;

use App\Models\Peneliti;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;


class SuratPenugasanRequest extends FormRequest
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
        $id = $this->route('surat_penugasan');
        return [
            'nomor_surat' => [
                'required',
                'max:255',
                'string',
                Rule::unique('surat_penugasans', 'nomor_surat')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'user_role_id' => 'required|exists:user_roles,id',
            'peneliti_id' => [
                'required',
                'exists:penelitis,id',
                Rule::unique('surat_penugasans', 'peneliti_id')->ignore($id), // Abaikan record dengan ID ini saat update
                function ($attribute, $value, $fail) {
                    $peneliti = Peneliti::where('id', $value)
                        ->where('is_selesai', 1)
                        ->where('is_valid', 1)
                        ->first();

                    if (!$peneliti) {
                        $fail('status verifikasi harus selesai dan valid.');
                    }
                }
            ],
            'tanggal_surat' => 'required|date_format:Y-m-d'

            //untuk validasi update ttd ketua lppm
            // 'ketua_lppm_role_id' => 'required|exists:user_roles,id',
            // 'is_disetujui' => 'nullable|boolean',
            // 'catatan' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_role_id' => 'jfu lppm',
            'peneliti_id' => 'peneliti',
            'nomor_surat' => 'nomor surat',
            'tanggal_surat' => 'tanggal surat', // validasi format tanggal
        ];
    }
}
