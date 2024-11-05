<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRequest extends FormRequest
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
        $id = $this->route('user');

        // Inisialisasi aturan dasar
        $rules = [
            // untuk tabel users
            'name' => 'required|string',
            'email' => [
                'required',
                'email',
                'string',
                Rule::unique('users', 'email')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            // 'email' => 'required|email|unique:users,email,' . $id,

            // untuk tabel identitas
            'jenis_kelamin' => 'required|string',
            'gelar_depan' => 'nullable|string',
            'gelar_belakang' => 'nullable|string',
            'no_hp' => 'nullable|string',
            'foto' => 'nullable|file|mimes:jpg,jpeg,png|max:2048',

            'nip' => [
                'nullable',
                'string',
                Rule::unique('identitas', 'nip')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'nidn' => [
                'nullable',
                'string',
                Rule::unique('identitas', 'nidn')->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'jabatan' => 'nullable|string',
            'unit_kerja_id' => 'required|exists:unit_kerjas,id',
            'pangkat_id' => 'required|exists:pangkats,id',
        ];

        // Jika metode adalah POST, tambahkan aturan untuk password
        if ($this->isMethod('post')) {
            $rules['password'] = 'required|string|min:8';
            $rules['password_lagi'] = 'required|string|same:password';
        } elseif ($this->isMethod('put') || $this->isMethod('patch')) {
            $rules['password'] = 'nullable|string|min:8';
            if ($this->input('password') != '')
                $rules['password_lagi'] = 'required|string|same:password';
        }
        return $rules;
    }

    public function attributes(): array
    {
        return [
            'name' => 'nama lengkap tanpa gelar',
            'email' => 'email pribadi',
            'gelar_depan' => 'gelar depan',
            'gelar_belakang' => 'gelar belakang',
            'jenis_kelamin' => 'jenis kelamin',
            'jabatan' => 'jabatan',
            'no_hp' => 'nomor HP/WA',
            'foto' => 'foto',
            'nip' => 'nomor input pegawai (NIP)',
            'nidn' => 'nomor induk dosen (NIDN)',
            'unit_kerja_id' => 'unit kerja id',
            'pangkat_id' => 'pangkat id',
            'password' => 'password',
            'password_lagi' => 'ulangi password',
        ];
    }
}
