<?php

namespace App\Repositories\Proxy;

use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Contracts\IBaseRepository;
use App\Repositories\Contracts\User\IUserRepository;

class RepositoryProxy
{
    protected array $repositoryMap = [
        'blog' => IBlogRepository::class,
        'category' => ICategoryRepository::class,
        'user' => IUserRepository::class
    ];

    public function for(string $repositoryName): ?IBaseRepository
    {
        if (!isset($this->repositoryMap[$repositoryName]))
            return null;

        return resolve($this->repositoryMap[$repositoryName]);
    }

}
