<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PersetujuanSuratPenugasanRequest extends FormRequest
{
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
        $rules = [
            'is_disetujui' => 'required|boolean',
            'catatan' => 'nullable|string',
            'ketua_lppm_role_id' => 'required|integer|exists:user_roles,id',
        ];
        if (!$this->input('is_disetujui')) {
            $rules['catatan'] = 'required|string';
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'is_valid' => 'hasil verifikasi',
            'catatan' => 'catatan verifikasi',
            'ketua_lppm_role_id' => 'ketua lppm',
        ];
    }
}
