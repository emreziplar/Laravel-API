<?php

namespace App\Contracts;

use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;

interface IBaseService
{
    public function create(array $data, ?IUserModel $user = null): ModelResponseDTO;

    public function get(array $fields): ModelResponseDTO;

    public function update(int $id, array $data, ?IUserModel $user = null): ModelResponseDTO;

    public function delete(int $id, ?IUserModel $user = null): ModelResponseDTO;
}
