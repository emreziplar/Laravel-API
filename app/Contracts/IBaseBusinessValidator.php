<?php

namespace App\Contracts;

use App\Models\Contracts\IUserModel;
use App\Support\Validation\ValidationResult;

interface IBaseBusinessValidator
{
    public function validateForCreate(array $data, ?IUserModel $user = null): ValidationResult;

    public function validateForUpdate(int $id, array $data, ?IUserModel $user = null): ValidationResult;

    public function validateForDelete(int $id, ?IUserModel $user = null): ValidationResult;
}
