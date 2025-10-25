<?php

namespace App\Contracts\Media;

use App\DTO\Request\Media\CreateMediaDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;

interface IMediaService
{
    public function create(CreateMediaDTO $createMediaDTO, ?IUserModel $user = null): ModelResponseDTO;

    public function get(array $fields): ModelResponseDTO;

    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO;
}
