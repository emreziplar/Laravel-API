<?php

namespace App\Contracts;

use App\Support\Validation\ValidationResult;

interface IBaseDataValidator
{
    public function validateCreateData(array $data): ValidationResult;

    public function validateGetData(array $data): ValidationResult;

    public function validateUpdateData(int $id, array $data): ValidationResult;

    public function validateDeleteData(int $id): ValidationResult;
}
