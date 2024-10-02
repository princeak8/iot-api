<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ComponentCategoryResource;
use App\Http\Resources\ParameterResource;

class ComponentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "id" => $this->id,
            "name" => $this->name,
            "codeName" => $this->code_name,
            "category" => new ComponentCategoryResource($this->category),
            "parameters" => ParameterResource::collection($this->whenLoaded('parameters'))
        ];
    }
}
