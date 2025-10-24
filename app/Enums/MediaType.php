<?php

namespace App\Enums;

use App\Http\Resources\Blog\BlogResource;
use App\Http\Resources\Category\CategoryResource;
use App\Http\Resources\User\UserResource;
use App\Repositories\Contracts\Blog\IBlogRepository;
use App\Repositories\Contracts\Category\ICategoryRepository;
use App\Repositories\Contracts\User\IUserRepository;
use App\Services\Media\Handlers\AudioHandler;
use App\Services\Media\Handlers\ImageHandler;
use App\Services\Media\Handlers\VideoHandler;

enum MediaType: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';

    public static function fromMimeType(string $mimeType): ?self
    {
        return match (true) {
            str_starts_with($mimeType, 'image') => self::IMAGE,
            str_starts_with($mimeType, 'video') => self::VIDEO,
            str_starts_with($mimeType, 'audio') => self::AUDIO,
            default => null
        };
    }

    public function getHandlerClass(): string
    {
        return match ($this) {
            self::IMAGE => ImageHandler::class,
            self::VIDEO => VideoHandler::class,
            self::AUDIO => AudioHandler::class
        };
    }
}
