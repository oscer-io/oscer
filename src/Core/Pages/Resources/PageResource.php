<?php

namespace Bambamboole\LaravelCms\Core\Pages\Resources;

use Bambamboole\LaravelCms\Core\Users\Resources\UserResource;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'featured_image' => $this->when($this->featured_image !== null, Storage::url($this->featured_image)),
            'name' => $this->name,
            'slug' => $this->slug,
            'body' => $this->body,
            'author' => new UserResource($this->whenLoaded('author')),
            'author_id' => $this->author_id,
            'published_at' => $this->published_at,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
