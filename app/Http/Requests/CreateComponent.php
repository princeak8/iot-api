<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

class CreateComponent extends BaseRequest
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
        $rules = [
            "name" => "required|string",
            "codeName" => "required|string",
            "categoryId" => "required|integer|exists:component_categories,id",
            "subModuleId" => "required|integer|exists:sub_modules,id",
            "actionable" => "nullable|boolean",
            "topic" => "nullable|required_if:actionable,true|string",
            "parameterIds" => "nullable|array",
            "parameterIds.*" => "integer|exists:parameters,id"
        ];
        return $rules;
    }
}
