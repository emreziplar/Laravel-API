<?php

namespace App\Http\Controllers;

use App\Traits\Response\HttpResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

abstract class Controller
{
    use HttpResponse;

    /**
     * @param class-string<JsonResource> $resourceClass
     */
    protected function toResource(string $resourceClass, $data): JsonResource|AnonymousResourceCollection|null
    {
        if (!$data) return null;

        return $data instanceof Collection
            ? $resourceClass::collection($data)
            : new $resourceClass($data);
    }
}
