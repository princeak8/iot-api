<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ComponentResource;
use App\Http\Resources\ParameterResource;

class ComponentCategoryResource extends JsonResource
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
            "parameters" => ParameterResource::collection($this->whenLoaded('parameters')),
            "components" => ComponentResource::collection($this->whenLoaded('components'))    
        ];
    }
}
