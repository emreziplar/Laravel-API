<?php

namespace App\Contracts;

use App\DTO\Response\BaseResponseDTO;

interface IBaseService
{
    public function create(array $data): BaseResponseDTO;

    public function get(array $fields): BaseResponseDTO;

    public function update(int $id, array $data): BaseResponseDTO;

    public function delete(int $id): BaseResponseDTO;
}
