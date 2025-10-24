<?php

namespace App\Contracts\Media;

use App\DTO\Request\Media\CreateMediaDTO;
use App\DTO\Response\ModelResponseDTO;

interface IMediaService
{
    public function create(CreateMediaDTO $createMediaDTO): ModelResponseDTO;

    public function get(array $fields): ModelResponseDTO;

    public function delete(int $id): ModelResponseDTO;
}
