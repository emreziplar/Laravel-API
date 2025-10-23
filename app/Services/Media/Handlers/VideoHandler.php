<?php

namespace App\Services\Media\Handlers;

use App\Contracts\Media\IMediaHandler;
use App\Models\Contracts\IBaseModel;
use Illuminate\Http\UploadedFile;

class VideoHandler implements IMediaHandler
{

    public function store(UploadedFile $file, string $dir = '')
    {
        // TODO: Implement store() method.
    }
}
