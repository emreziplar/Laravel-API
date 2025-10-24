<?php

namespace App\Services\Media;

use App\Contracts\Media\IMediaHandler;
use App\Enums\MediaType;
use App\Support\Media\Media;
use Illuminate\Http\UploadedFile;

class MediaHandlerProxy implements IMediaHandler
{
    /**
     * @param UploadedFile $file
     * @param string $dir
     * @return mixed
     * @throws \Exception
     */
    public function store(UploadedFile $file, string $dir = '')
    {
        if (!in_array($file->getClientOriginalExtension(), Media::getAllowedFileExtensions()))
            throw new \Exception('Unsupported file extension!');

        $mediaType = MediaType::fromMimeType($file->getMimeType());

        if (!$mediaType)
            throw new \Exception('Unsupported file type!');

        /** @var IMediaHandler $handler */
        $handler = app($mediaType->getHandlerClass());

        return $handler->store($file, $dir);
    }
}
