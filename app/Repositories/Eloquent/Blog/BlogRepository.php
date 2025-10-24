<?php

namespace App\Repositories\Eloquent\Blog;

use App\DTO\Request\Blog\CreateBlogDTO;
use App\DTO\Request\Blog\UpdateBlogDTO;
use App\Models\Contracts\IBlogModel;
use App\Models\Eloquent\Blog;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogRepository extends BaseEloquentRepository implements IBlogRepository
{
    public function getModelClass(): string
    {
        return Blog::class;
    }

    protected function getDefaultRelations(): array
    {
        return ['translations'];
    }

    public function createWithTranslations(CreateBlogDTO $createBlogDTO): ?IBlogModel
    {
        return DB::transaction(function () use ($createBlogDTO) {
            /** @var Blog $blog */
            $blog = $this->model->create([
                'category_id' => $createBlogDTO->categoryId,
                'status' => $createBlogDTO->status
            ]);

            $blog->translations()->createMany(
                collect($createBlogDTO->translations)->map(function ($t) use ($createBlogDTO) {
                    return [
                        'author_id' => $createBlogDTO->user->getId(),
                        'title' => $t['title'],
                        'slug' => $t['slug'] ?? Str::slug($t['title']),
                        'content' => $t['content'],
                        'lang_code' => $t['lang_code']
                    ];
                })
            );

            return $blog->load($this->getDefaultRelations());
        });
    }

    public function updateWithTranslations(UpdateBlogDTO $updateBlogDTO): ?IBlogModel
    {
        return DB::transaction(function () use ($updateBlogDTO) {
            /** @var Blog $blogModel */
            $blogModel = $updateBlogDTO->blog;

            $blogData = array_filter([
                'category_id' => $updateBlogDTO->categoryId,
                'status' => $updateBlogDTO->status,
            ], fn($value) => $value !== null);

            if (!empty($blogData))
                $blogModel->update($blogData);

            collect($updateBlogDTO->translations ?? [])->each(function ($t) use ($blogModel) {

                $translationData = array_filter([
                    'title' => $t['title'] ?? null,
                    'slug' => $t['slug'] ?? null,
                    'content' => $t['content'] ?? null,
                ], fn($value) => $value !== null);

                if (!isset($translationData['slug']) && isset($translationData['title']))
                    $translationData['slug'] = Str::slug($translationData['title']);

                if (!empty($translationData))
                    $blogModel->translations()->updateOrCreate(
                        ['lang_code' => $t['lang_code']],
                        $translationData
                    );

            });
            return $blogModel->load($this->getDefaultRelations());
        });
    }
}
