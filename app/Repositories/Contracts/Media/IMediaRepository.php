<?php

namespace App\Repositories\Contracts\Media;

use App\Models\Contracts\IBaseModel;
use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Support\Collection;

interface IMediaRepository extends IBaseRepository
{
    public function createForModel(IBaseModel $model, array $fields): IBaseModel|Collection|null;
}
