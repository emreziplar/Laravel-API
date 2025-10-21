<?php

namespace App\Contracts;

use App\DTO\Response\ModelResponseDTO;

interface IBaseService
{
    public function create(array $data): ModelResponseDTO;

    public function get(array $fields): ModelResponseDTO;

    public function update(int $id, array $data): ModelResponseDTO;

    public function delete(int $id): ModelResponseDTO;
}
