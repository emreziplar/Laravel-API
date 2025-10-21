<?php

namespace App\Repositories\Eloquent\Blog;

use App\DTO\Request\Blog\CreateBlogDTO;
use App\Models\Contracts\IBlogModel;
use App\Models\Eloquent\Blog;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class BlogRepository extends BaseEloquentRepository implements IBlogRepository
{
    protected function getModelClass()
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
}
