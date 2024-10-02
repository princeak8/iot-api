<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ClientResource;
use App\Http\Resources\UserResource;

class ProfileResource extends JsonResource
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
            "about" => $this->about,
            "client" => new ClientResource($this->client),
            "users" => UserResource::collection($this->whenLoaded("users"))
        ];
    }
}
