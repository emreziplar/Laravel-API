<?php

namespace App\Services\Media\Handlers;

use App\Contracts\Media\IMediaHandler;
use App\Support\Media\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class VideoHandler implements IMediaHandler
{

    public function store(UploadedFile $file, string $dir = '')
    {
        $fileName = $file->hashName();
        $filePath = Media::getVideoPath($dir . '/' . $fileName);

        $is_stored = Storage::disk('public')->putFileAs(
            dirname($filePath),
            $file,
            basename($filePath)
        );

        if (!$is_stored) {
            throw new \Exception("Failed to store video: {$filePath}");
        }

        return [
            'type' => 'video',
            'file_name' => $fileName,
            'path' => $filePath
        ];
    }
}
