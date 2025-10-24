<?php

namespace App\Http\Resources;

use App\Enums\ResourceType;

class ResourceProxy
{
    public function on(ResourceType $resourceType): ?string
    {
        return $resourceType->getResourceClass();
    }
}
