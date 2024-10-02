<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class CreateUserByAdmin extends BaseRequest
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
        return [
            "client_id" => "required|integer|exists:clients,id",
            "firstname" => "required|string",
            "lastname" => "nullable|string",
            "username" => ["required",Rule::unique('users')
            ->where(function ($query) {
                return $query->where('client_id', $this->client_id);
            })],
            "email" => ["required", "email", Rule::unique('users')
            ->where(function ($query) {
                return $query->where('client_id', $this->client_id);
            })],
            "roleId" => "required|integer|exists:roles,id",
            "permissionId" => "nullable|integer|exists:permissions,id"
        ];
    }
}
