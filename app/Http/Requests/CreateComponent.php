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
            "identifier" => "required|string",
            "categoryId" => "required|integer|exists:component_categories,id",
            "moduleId" => "required|integer|exists:modules,id",
            "topic" => "nullable|string"
        ];
        $rules["identifier"] = Rule::unique('components')->where(fn (Builder $query) => $query->where('module_id', $this->moduleId));
        return $rules;
    }
}
