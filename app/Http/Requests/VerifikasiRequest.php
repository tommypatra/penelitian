<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerifikasiRequest extends FormRequest
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
        $rules = [
            'is_valid' => 'required|boolean',
            'catatan' => 'nullable|string',
            'admin_role_id' => 'required|integer|exists:user_roles,id',
        ];
        if (!$this->input('is_valid')) {
            $rules['catatan'] = 'required|string';
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'is_valid' => 'hasil verifikasi',
            'catatan' => 'catatan verifikasi',
            'admin_role_id' => 'verifikator',
        ];
    }
}
