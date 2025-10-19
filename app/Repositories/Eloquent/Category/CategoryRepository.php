<?php

namespace App\Repositories\Eloquent\Category;

use App\Models\Contracts\IBaseModel;
use App\Models\Eloquent\Category;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryRepository extends BaseRepository implements ICategoryRepository
{
    protected function getModelClass()
    {
        return Category::class;
    }

    public function create(array $data): ?IBaseModel
    {
        $category_data = [
            'parent_id' => $data['parent_id'] ?? null,
            'status' => $data['status'] ?? 0
        ];
        $translations = $data['translations'];
        return DB::transaction(function () use ($category_data, $translations) {
            /** @var Category $category */
            $category = $this->model->create($category_data);

            $category->translations()->createMany(
                collect($translations)->map(function ($t) {
                    return [
                        'name' => $t['name'],
                        'slug' => $t['slug'] ?? Str::slug($t['name']),
                        'lang_code' => $t['lang_code']
                    ];
                })
            );

            return $category->load(['translations','parent.translations']);
        });
    }

    public function getWithConditions(array $fields = []): Collection
    {
        //TODO: use with / try all() get(id)
        return parent::getWithConditions($fields);
    }


}
