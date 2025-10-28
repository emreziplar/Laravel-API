<?php

namespace App\Repositories\Eloquent\Category;

use App\DTO\Request\Category\CreateCategoryDTO;
use App\DTO\Request\Category\UpdateCategoryDTO;
use App\Models\Contracts\IBaseModel;
use App\Models\Contracts\ICategoryModel;
use App\Models\Eloquent\Category;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategoryRepository extends BaseEloquentRepository implements ICategoryRepository
{
    protected function getDefaultRelations(): array
    {
        return ['translations', 'parent.translations', 'media'];
    }

    public function getModelClass(): string
    {
        return Category::class;
    }

    public function createWithTranslations(CreateCategoryDTO $createCategoryDTO): ?ICategoryModel
    {
        return DB::transaction(function () use ($createCategoryDTO) {
            /** @var Category $category */
            $category = $this->model->create([
                'parent_id' => $createCategoryDTO->parentId ?? null,
                'status' => $createCategoryDTO->status ?? 0
            ]);

            $category->translations()->createMany(
                collect($createCategoryDTO->translations)->map(function ($t) {
                    return [
                        'name' => $t['name'],
                        'slug' => $t['slug'] ?? Str::slug($t['name']),
                        'lang_code' => $t['lang_code']
                    ];
                })
            );
            return $category->load($this->getDefaultRelations());
        });
    }

    public function updateWithTranslations(UpdateCategoryDTO $updateCategoryDTO): ?ICategoryModel
    {
        /** @var Category $category */
        return DB::transaction(function () use ($updateCategoryDTO) {
            $categoryModel = $updateCategoryDTO->category;
            $category_data = [];

            if ($updateCategoryDTO->status !== null)
                $category_data['status'] = $updateCategoryDTO->status;
            if ($updateCategoryDTO->parentId !== null)
                $category_data['parent_id'] = $updateCategoryDTO->parentId === 0 ? null : $updateCategoryDTO->parentId;


            if (!empty($category_data))
                $categoryModel->update($category_data);

            foreach ($updateCategoryDTO->translations as $t) {
                $categoryModel->translations()->updateOrCreate(
                    ['lang_code' => $t['lang_code']],
                    [
                        'name' => $t['name'],
                        'slug' => $t['slug'] ?? Str::slug($t['name']),
                    ]
                );
            }

            return $categoryModel->load($this->getDefaultRelations());
        });
    }

    public function getFullPath(ICategoryModel $categoryModel): string
    {
        $locale = App::getLocale();

        $names = [];

        $category = $categoryModel;

        while ($category) {

            $translation = $category->translations->firstWhere('lang_code', $locale);

            if (!$translation) {
                $translation = $category->translations->firstWhere(
                    'lang_code',
                    config('app.fallback_locale', 'en')
                );
            }

            $names[] = $translation->name ?? '';
            $category = $category->parent;
        }

        $names = array_reverse($names);
        return implode(' > ', $names);
    }
}
