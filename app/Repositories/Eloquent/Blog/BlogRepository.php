<?php

namespace App\Repositories\Eloquent\Blog;

use App\Models\Contracts\IBaseModel;
use App\Models\Contracts\IBlogModel;
use App\Models\Contracts\IUserModel;
use App\Models\Eloquent\Blog;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Facades\DB;

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

    public function createWithTranslations(array $blogData, array $translationsData, IUserModel $user): ?IBlogModel
    {
        return DB::transaction(function () use ($blogData, $translationsData, $user) {
            /** @var Blog $blog */
            $blog = $this->model->create($blogData);

            $blog->translations()->createMany(
                collect($translationsData)->map(function ($t) use ($user) {
                    return [
                        'author_id' => $user->getId()
                    ];
                })
            );
        });
    }
}
