<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class CreateProfile extends BaseRequest
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
            "clientId" => "required|integer|exists:clients,id",
            "about" => "required|string",
            "name" => ["required",Rule::unique('profiles')
            ->where(function ($query) {
                return $query->where('client_id', $this->client_id);
            })],
        ];
    }
}
