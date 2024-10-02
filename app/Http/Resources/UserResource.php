<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

use App\Http\Resources\ClientResource;
use App\Http\Resources\PermissionResource;
use App\Http\Resources\RoleResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "firstname" => $this->firstname,
            "lasstname" => $this->lastname,
            "username" => $this->username,
            "email" => $this->email,
            "lastLogin" => $this->last_login,
            "client" => new ClientResource($this->whenLoaded("clients")),
            "permission" => new PermissionResource($this->whenLoaded("permission")),
            "role" => new RoleResource($this->whenLoaded("role"))
        ];
    }
}
