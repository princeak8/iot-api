<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;

use App\Rules\ComponentBelongsToGroup;

class PublishingConfig extends BaseRequest
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
            "groups" => "array|required_without:components",
            "groups.*" => "array",
            "groups.*.groupId" => "integer|distinct",
            "groups.*.components" => "array",
            "groups.*.components.*" => "integer",
            "components" => "array|required_without:groups",
            "components.*" => "integer"
        ];
    }

    public function messages()
    {
        $messages = [];
        $messages['groups.*.groupId.distinct'] = "groupId value must be unique";

        return $messages;
    }
}
