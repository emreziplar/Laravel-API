<?php

namespace App\Repositories\Eloquent\Category;

use App\Models\Contracts\IBaseModel;
use App\Models\Eloquent\Category;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryRepository extends BaseEloquentRepository implements ICategoryRepository
{
    protected function getDefaultRelations(): array
    {
        return ['translations', 'parent.translations'];
    }

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

            return $category->load(['translations', 'parent.translations']);
        });
    }

    public function update(IBaseModel $baseModel, array $data): ?IBaseModel
    {
        $category_data = [];

        if (!is_null($data['status'] ?? null))
            $category_data['status'] = $data['status'];
        if (!is_null($data['parent_id'] ?? null))
            $category_data['parent_id'] = $data['parent_id'] === 0 ? null : $data['parent_id'];
        $translations = $data['translations'];

        /** @var Category $baseModel */
        return DB::transaction(function () use ($baseModel, $category_data, $translations) {
            /** @var Category $category */
            if (!empty($category_data))
                $baseModel->update($category_data);

            foreach ($translations as $t) {
                $baseModel->translations()->updateOrCreate(
                    ['lang_code' => $t['lang_code']],
                    [
                        'name' => $t['name'],
                        'slug' => $t['slug'] ?? Str::slug($t['name']),
                    ]
                );
            }

            return $baseModel->load(['translations', 'parent.translations']);
        });
    }


}
