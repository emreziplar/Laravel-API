<?php

namespace App\Repositories\Proxy;

use App\Enums\ResourceType;
use App\Repositories\Contracts\IBaseRepository;

class RepositoryProxy
{
    public function on(ResourceType $resourceType): ?IBaseRepository
    {
        return resolve($resourceType->getRepositoryInterface());
    }
}
