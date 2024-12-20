<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class JenisPenelitianRequest extends FormRequest
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
        $id = $this->route('jenis_penelitian');
        return [
            'nama' => [
                'required',
                'max:255',
                'string',
                Rule::unique('jenis_penelitians', 'nama')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            // 'nama' => 'required|string|max:255|unique:jenis_penelitians,nama,' . $id,
            'keterangan' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'jenis penelitian',
            'keterangan' => 'keterangan',
        ];
    }
}
