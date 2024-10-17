<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PenelitianRequest extends FormRequest
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
        $id = $this->route('penelitian');
        return [
            'nama' => [
                'required',
                'string',
                Rule::unique('penelitians')
                    ->where('tahun', $this->tahun) // unik 2 kolom 
                    // ->where('user_role_id', $this->user_role_id) // unik lebih dari 2 kolom 
                    ->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'tahun' => 'required|integer|min:1900|max:' . date('Y'), // validasi tahun, pastikan integer
            'daftar_mulai' => 'nullable|date_format:Y-m-d', // validasi format tanggal
            'daftar_selesai' => 'nullable|date_format:Y-m-d', // validasi format tanggal
            'daftar_terbuka' => 'nullable|boolean', // tipe data boolean            
            'jenis_penelitian_id' => 'required|exists:jenis_penelitians,id',
            'user_role_id' => 'required|exists:user_roles,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'nama' => 'nama penelitian',
            'tahun' => 'tahun',
            'daftar_mulai' => 'tanggal mulai pendaftaran',
            'daftar_selesai' => 'tanggal selesai pendaftaran',
            'daftar_terbuka' => 'pembukaan pendaftaran',
            'jenis_penelitian_id' => 'jenis penelitian',
            'user_role_id' => 'role user',
        ];
    }
}
