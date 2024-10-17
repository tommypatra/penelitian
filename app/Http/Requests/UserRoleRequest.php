<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UserRoleRequest extends FormRequest
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
        $id = $this->route('user_role');
        return [
            'user_id' => [
                'required',
                'integer',
                'exists:users,id',
                Rule::unique('user_roles')
                    ->where('role_id', $this->role_id)
                    ->ignore($id), // Abaikan record dengan ID ini saat update
            ],
            'role_id' => 'required|integer|exists:roles,id',
        ];
    }

    public function attributes(): array
    {
        return [
            'user_id' => 'user',
            'role_id' => 'role',
        ];
    }
}
