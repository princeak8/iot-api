<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ModuleResource;
use App\Http\Resources\ComponentResource;

class SubModuleResource extends JsonResource
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
            "topic" => $this->topic,
            "description" => $this->description,
            "module" => new ModuleResource($this->whenLoaded("module")),
            "components" => ComponentResource::collection($this->whenLoaded("components"))
        ];
    }
}
