<?php

namespace App\Http\Resources\Blog;

use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\Media\ModelMediaResource;
use App\Models\Contracts\IBlogModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IBlogModel
 */
class BlogResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'status' => $this->status,
            'category' => new CategoryResource($this->category),
            'translations' => BlogTranslationResource::collection($this->translations),
            'media' => ModelMediaResource::collection($this->media)
        ];
    }
}
