<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ComponentResource;
use App\Http\Resources\ComponentCategoryResource;

class ParameterResource extends JsonResource
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
            "unit" => $this->unit,
            "components" => ComponentResource::collection($this->whenLoaded('components')),
            "categories" => ComponentCategoryResource::collection($this->whenLoaded('categories'))
        ];
    }
}
