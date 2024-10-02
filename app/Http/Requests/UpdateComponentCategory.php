<?php

namespace App\Http\Requests;

use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateComponentCategory extends FormRequest
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
            "id" => "required|integer",
            "name" => ['nullable','string', Rule::unique('component_categories')->where(function($query) use($profileId) {
                return $query->where('profile_id', $profileId)->where('id', '!=', $this->id);
            })],
            "moduleId" => "nullable|exists:modules,id" 
        ];
    }
}
