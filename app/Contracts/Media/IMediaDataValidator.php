<?php

namespace App\Contracts\Media;

use App\DTO\Request\Media\CreateMediaDTO;
use App\Support\Validation\ValidationResult;

interface IMediaDataValidator
{
    public function validateCreateData(CreateMediaDTO $createMediaDTO): ValidationResult;

    public function validateGetData(array $data): ValidationResult;

    public function validateDeleteData(int $id): ValidationResult;
}
