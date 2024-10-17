<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UploadDokumenPenelitiRequest extends FormRequest
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
        $id = $this->route('upload_dokumen_peneliti');

        $rules = [
            'keterangan' => 'nullable|string',
            'dokumen_id' => 'required|exists:dokumens,id',
            'peneliti_id' => 'required|exists:penelitis,id',
        ];

        // Jika metode adalah POST wajib upload
        if ($this->isMethod('post')) {
            $rules['dokumen'] = 'required|file|mimes:pdf,jpg,jpeg,png|max:10240';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['dokumen'] = 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240';
        }

        return $rules;
    }

    public function attributes(): array
    {
        return [
            'path' => 'dokumen upload',
            'keterangan' => 'keterangan',
            'dokumen_id' => 'syarat',
            'peneliti_id' => 'peneliti',
        ];
    }
}
