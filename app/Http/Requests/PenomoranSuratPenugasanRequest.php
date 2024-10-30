<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PenomoranSuratPenugasanRequest extends FormRequest
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
            'nomor_surat' => 'required|string',
            'tanggal_surat' => 'nullable|date_format:Y-m-d', // validasi format tanggal
        ];
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'nomor_surat' => 'nomor surat',
            'tanggal_surat' => 'tanggal surat',
        ];
    }
}
