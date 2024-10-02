<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class CreateUser extends BaseRequest
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
            "firstname" => "required|string",
            "lastname" => "nullable|string",
            "username" => ["required",Rule::unique('users')
            ->where(function ($query) {
                return $query->where('client_id', Auth::user()->client->id);
            })],
            "email" => ["required", "email", Rule::unique('users')
            ->where(function ($query) {
                return $query->where('client_id', Auth::user()->client->id);
            })],
            "roleId" => "required|integer|exists:roles,id",
            "permissionId" => "nullable|integer|exists:permissions,id"
            // "profileId" => "required|integer|exists:profiles,id"
        ];
    }
}
