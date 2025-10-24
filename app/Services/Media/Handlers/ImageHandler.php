<?php

namespace App\Services\Media\Handlers;

use App\Contracts\Media\IMediaHandler;
use App\Support\Media\Media;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;

class ImageHandler implements IMediaHandler
{
    public function store(UploadedFile $file, string $dir = '')
    {
        $image = Image::read($file->getRealPath())->encodeByExtension('webp', 90);

        $fileName = pathinfo($file->hashName(), PATHINFO_FILENAME) . '.webp';
        $filePath = Media::getImagePath($dir . '/' . $fileName);

        $is_stored = Storage::disk('public')->put($filePath, $image);

        if (!$is_stored)
            throw new \Exception("Failed to store image: {$filePath}");

        return [
            'type' => 'image',
            'file_name' => $fileName,
            'path' => $filePath
        ];
    }
}
