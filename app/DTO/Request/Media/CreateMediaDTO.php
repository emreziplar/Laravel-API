<?php

namespace App\DTO\Request\Media;

use App\Enums\ResourceType;

class CreateMediaDTO
{
    public function __construct(
        public readonly ResourceType $resourceType,
        public readonly int          $resourceId,
        public readonly array        $files
    )
    {
    }
}
