<?php

namespace App\Http\Resources\Api;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{

    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'content' => $this->content,
            'user_id' => $this->user_id,
            'created_at' => $this->created_at->format('d/m/Y à H:i:s'),
            'updated_at' => $this->updated_at->format('d/m/Y à H:i:s'),
            'user' => UserResource::make($this->whenLoaded('user')),
            'categories' => CategoryCollection::make($this->whenLoaded('categories')),
        ];
    }
}
