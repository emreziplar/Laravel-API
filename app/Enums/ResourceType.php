<?php

namespace App\Enums;

use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Contracts\User\IUserRepository;

enum ResourceType: string
{
    case CATEGORY = 'category';
    case BLOG = 'blog';
    case USER = 'user';

    public static function values()
    {
        return array_column(self::cases(), 'value');
    }

    public function getRepositoryInterface(): string
    {
        return match ($this) {
            self::CATEGORY => ICategoryRepository::class,
            self::BLOG => IBlogRepository::class,
            self::USER => IUserRepository::class,
        };
    }

    public function getResourceClass(): string
    {
        return match ($this) {
            self::CATEGORY => CategoryResource::class,
            self::BLOG => BlogResource::class,
            self::USER => UserResource::class,
        };
    }
}
