<?php

namespace App\Models\Contracts;

interface IMediaModel extends IBaseModel
{
    public function getMediableType(): string;

    public function getPath(): string;
}
