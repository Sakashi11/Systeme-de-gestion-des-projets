<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TeamResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'name'        => $this->name,
            'description' => $this->description,
            'owner'       => new UserResource($this->whenLoaded('owner')),
            'members'     => UserResource::collection($this->whenLoaded('members')),
            'projects'    => ProjectResource::collection($this->whenLoaded('projects')),
            'created_at'  => $this->created_at,
        ];
    }
}