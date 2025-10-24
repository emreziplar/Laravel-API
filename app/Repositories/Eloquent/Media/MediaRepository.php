<?php

namespace App\Repositories\Eloquent\Media;

use App\Models\Contracts\IBaseModel;
use App\Models\Eloquent\Media;
use App\Repositories\Contracts\Media\IMediaRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MediaRepository extends BaseEloquentRepository implements IMediaRepository
{
    public function getModelClass(): string
    {
        return Media::class;
    }

    protected function getDefaultRelations(): array
    {
        return ['mediable'];
    }


    public function createForModel(IBaseModel $model, array $fields): ?IBaseModel
    {
        /** @var Model $model */
        return DB::transaction(function () use ($model, $fields) {
            if (!$model->isRelation('media'))
                return null;

            if (empty($fields))
                return null;

            $model->media()->createMany(
                collect($fields)->map(function ($item) use ($model) {
                    return [
                        'mediable_type' => $model,
                        'type' => $item['type'],
                        'path' => $item['path']
                    ];
                })
            );
            return $model->load('media');
        });
    }
}
