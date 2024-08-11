<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

use Illuminate\Support\Facades\Auth;

class UpdateModule extends BaseRequest
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
        $profileId = Auth::guard('profile')->user()->id;
        return [
            "id" => "required|integer|exists:modules,id",
            "name" => ['nullable','string', Rule::unique('modules')->where(function($query) use($profileId) {
                return $query->where('profile_id', $profileId);
            })],
            "description" => "nullable|string",
            "moduleTypeId" => "nullable|integer|exists:module_types,id"
        ];
    }
}
