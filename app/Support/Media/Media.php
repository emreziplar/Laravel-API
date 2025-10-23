<?php

namespace App\Support\Media;

class Media
{
    public static function getAllowedFileExtensions(bool $getMimeTypeNames = false): array
    {
        $fileExtensions = [
            'image' => ['webp', 'jpg', 'jpeg', 'png'],
            'video' => ['mp4'],
            'audio' => ['mp3']
        ];

        if (!$getMimeTypeNames)
            return array_merge(...array_values($fileExtensions)); //webp,jpg...,mp4,mp3: only extensions

        return $fileExtensions;
    }

    public static function getMediaPath(string $path = '')
    {
        return 'media/' . $path;
    }
}
