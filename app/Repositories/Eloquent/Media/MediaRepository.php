<?php

namespace App\Repositories\Eloquent\Media;

use App\Models\Contracts\IBaseModel;
use App\Models\Eloquent\Media;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Collection;

class MediaRepository extends BaseEloquentRepository implements IMediaRepository
{
    protected function getModelClass()
    {
        return Media::class;
    }

    public function createForModel(IBaseModel $model, array $fields): IBaseModel|Collection|null
    {
        return $model->media()->createMany(
            collect($fields)->map(function ($item) {
                return [
                    'type' => $item['type'],
                    'path' => $item['path']
                ];
            })
        );
    }
}
