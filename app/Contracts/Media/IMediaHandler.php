<?php

namespace App\Contracts\Media;

use Illuminate\Http\UploadedFile;

interface IMediaHandler
{
    public function store(UploadedFile $file, string $dir = '');
}
