<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PenelitiRequest extends FormRequest
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
        $id = $this->route('peneliti');
        return [
            'user_role_id' => [
                'required',
                'integer',
                'exists:user_roles,id',
                Rule::unique('penelitis')
                    ->where('penelitian_id', $this->penelitian_id)
                    ->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'penelitian_id' => 'required|exists:penelitians,id',
            'judul' => 'required|string',
            // 'admin_role_id' => 'nullable|exists:user_roles,id',
            // 'is_selesai' => 'nullable|boolean',
            // 'is_valid' => 'nullable|boolean',
            // 'catatan' => 'nullable|string',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_role_id' => 'akun peneliti',
            'penelitian_id' => 'penelitian',
            'judul' => 'judul',
            // 'admin_role_id' => 'akun admin',
            // 'is_selesai' => 'status selesai',
            // 'is_valid' => 'status verifikasi',
            // 'catatan' => 'catatan',
        ];
    }
}
