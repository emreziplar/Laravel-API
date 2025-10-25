<?php

namespace App\Contracts\Media;

use App\DTO\Request\Media\CreateMediaDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\IBaseRepository;
use App\Support\Validation\ValidationResult;

interface IMediaBusinessValidator
{
    public function validateForCreate(CreateMediaDTO $createMediaDTO, ?IBaseRepository $repository = null): ValidationResult;

    public function validateForDelete(int $id, ?IUserModel $user = null): ValidationResult;
}
