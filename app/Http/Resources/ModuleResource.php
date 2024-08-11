<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ProfileResource;
use App\Http\Resources\ModuleTypeResource;
use App\Http\Resources\ComponentResource;

class ModuleResource extends JsonResource
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
            "profile" => new ProfileResource($this->profile),
            "description" => $this->description,
            "type" => new ModuleTypeResource($this->type),
            "components" => ComponentResource::collection($this->components)
        ];
    }
}
