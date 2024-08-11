<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Requests\BaseRequest;
use Illuminate\Validation\Rule;

class CreateViewer extends BaseRequest
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
            "name" => "required|string",
            "password" => "required|string",
            "username" => ["required",Rule::unique('viewers')
            ->where(function ($query) {
                return $query->where('profile_id', request('profile_id'));
            })],
            "profileId" => "required|integer|exists:profiles,id"
        ];
    }
}
