<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PangkatRequest extends FormRequest
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
        $id = $this->route('pangkat');
        return [
            'nama' => [
                'required',
                'max:255',
                'string',
                Rule::unique('pangkats', 'nama')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'gol' => [
                'required',
                'max:255',
                'string',
                Rule::unique('pangkats', 'gol')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'urut' => 'nullable|integer',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama pangkat',
            'urut' => 'urut',
        ];
    }
}
