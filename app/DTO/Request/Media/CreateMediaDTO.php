<?php

namespace App\DTO\Request\Media;

use App\Enums\ResourceType;
use App\Models\Contracts\IUserModel;

class CreateMediaDTO
{
    public function __construct(
        public readonly ResourceType $resourceType,
        public readonly int          $resourceId,
        public readonly array        $files,
        public readonly ?IUserModel  $user = null
    )
    {
    }
}
