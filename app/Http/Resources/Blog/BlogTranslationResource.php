<?php

namespace App\Http\Resources\Blog;

use App\Models\Contracts\IBlogTranslationModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin IBlogTranslationModel
 */
class BlogTranslationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'blog_id' => $this->blog_id,
            'author' => [
                'id' => $this->author->id,
                'name' => $this->author->name,
            ],
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content,
            'lang_code' => $this->lang_code
        ];
    }
}
