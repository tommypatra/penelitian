<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UnitKerjaRequest extends FormRequest
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
        $id = $this->route('unit_kerja');
        return [
            'nama' => [
                'required',
                'max:255',
                'string',
                Rule::unique('unit_kerjas', 'nama')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            // 'nama' => 'required|string|max:255|unique:unit_kerjas,nama,' . $id,
            'keterangan' => 'nullable',
            'is_pilihan' => 'required|boolean',
            'parent_id' => 'nullable|exists:unit_kerjas,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama unit kerja',
            'keterangan' => 'keterangan',
            'is_pilihan' => 'pilihan',
            'parent_id' => 'unit kerja utama',
        ];
    }
}
