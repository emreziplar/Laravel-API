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

    public static function getStoragePublicUrl(): string
    {
        return config('filesystems.disks.public.url') . '/';
    }

    public static function getStoragePublicPath(): string
    {
        return config('filesystems.disks.public.root') . '/';
    }

    public static function getMediaPath(string $path = ''): string
    {
        $path = self::sanitizePath($path);
        return 'media/' . $path;
    }

    public static function getImagePath(string $path = ''): string
    {
        $path = self::sanitizePath($path);
        return self::getMediaPath('image/' . $path);
    }

    public static function getVideoPath(string $path = ''): string
    {
        $path = self::sanitizePath($path);
        return self::getMediaPath('video/' . $path);
    }

    public static function getAudioPath(string $path = ''): string
    {
        $path = self::sanitizePath($path);
        return self::getMediaPath('audio/' . $path);
    }

    public static function sanitizePath(string $path): string
    {
        $path = str_replace(['..', '\\'], '', $path);

        return trim($path, '/');
    }

    public static function deleteFile(string $relativePath): bool
    {
        $fullPath = self::getStoragePublicPath() . $relativePath;

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return false;
    }
}
