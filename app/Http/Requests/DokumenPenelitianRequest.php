<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class DokumenPenelitianRequest extends FormRequest
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
        $id = $this->route('dokumen_penelitian');
        return [
            'nama' => [
                'required',
                'string',
                Rule::unique('dokumens')
                    ->where('penelitian_id', $this->penelitian_id) // unik 2 kolom 
                    ->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'jenis' => 'required|string',
            'tipe_file' => 'required|string',
            'is_wajib' => 'required|boolean',
            'keterangan' => 'nullable|string',
            'penelitian_id' => 'required|exists:penelitians,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama dokumen',
            'jenis' => 'jenis',
            'tipe_file' => 'tipe file',
            'is_wajib' => 'status wajib',
            'keterangan' => 'keterangan',
            'penelitian_id' => 'penelitian',
        ];
    }
}
