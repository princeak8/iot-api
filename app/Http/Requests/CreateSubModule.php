<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateSubModule extends BaseRequest
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
            "moduleId" => "required|integer|exists:modules,id",
            "name" => ['required','string', Rule::unique('sub_modules')->where(function($query) {
                return $query->where('module_id', $this->moduleId);
            })],
            "description" => "nullable|string",
            "topic" => "nullable|string"
        ];
    }
}
