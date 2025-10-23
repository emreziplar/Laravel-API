<?php

namespace App\Services\Media;

use App\Contracts\Media\IMediaHandler;
use App\Models\Contracts\IBaseModel;
use App\Services\Media\Handlers\AudioHandler;
use App\Services\Media\Handlers\ImageHandler;
use App\Services\Media\Handlers\VideoHandler;
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
        $mimeType = $file->getMimeType();

        if (!in_array($file->getClientOriginalExtension(), Media::getAllowedFileExtensions()))
            throw new \Exception('Unsupported file extension!');

        if (str_starts_with($mimeType, 'image'))
            $handler = app(ImageHandler::class);
        elseif (str_starts_with($mimeType, 'video'))
            $handler = app(VideoHandler::class);
        elseif (str_starts_with($mimeType, 'audio'))
            $handler = app(AudioHandler::class);
        else
            throw new \Exception('Unsupported file type!');

        return $handler->store($file, $dir);
    }
}
