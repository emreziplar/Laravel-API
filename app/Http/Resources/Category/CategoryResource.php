<?php

namespace App\Http\Resources\Category;

use App\Models\Contracts\ICategoryModel;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ICategoryModel
 */
class CategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->getId(),
            'names' => $this->translations?->pluck('name', 'lang_code'),
            'full_path' => $this->fullPath(),
            'parent' => $this->whenLoaded('parent', function () {
                return [
                    'id' => $this->parent->id,
                    'names' => $this->parent->translations?->pluck('name', 'lang_code')
                ];
            }),
        ];
    }
}
