<?php

namespace App\Repositories\Contracts\Media;

use App\Models\Contracts\IBaseModel;
use App\Repositories\Contracts\IBaseRepository;

interface IMediaRepository extends IBaseRepository
{
    public function createForModel(IBaseModel $model, array $fields): ?IBaseModel;
}
