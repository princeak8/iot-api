<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ComponentCategoryResource;
use App\Http\Resources\ModuleResource;

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
            "identifier" => $this->identifier,
            "category" => new ComponentCategoryResource($this->category),
            "module" => new ModuleResource($this->whenLoaded('module'))
        ];
    }
}
