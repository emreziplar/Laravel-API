<?php

namespace App\Repositories\Eloquent;

use App\Models\Contracts\IBaseModel;
use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


abstract class BaseEloquentRepository implements IBaseRepository
{
    protected Model|Builder $model;

    public function __construct()
    {
        $this->setModel();
    }

    private function setModel()
    {
        $modelClass = $this->getModelClass();
        $this->model = new $modelClass();
    }

    protected function getDefaultRelations(): array
    {
        return [];
    }

    public function all(): Collection
    {
        return $this->model->get();
    }

    public function create(array $data): ?IBaseModel
    {
        return $this->model->create($data);
    }

    public function getFirst(int|string $data, string $col = 'id'): ?IBaseModel
    {
        $q = $this->model->newQuery();

        if (!empty($this->getDefaultRelations())) {
            $q = $q->with($this->getDefaultRelations());
        }

        return $q->where($col, $data)->first();
    }

    public function getWithConditions(array $fields = []): Collection
    {
        $q = $this->model->newQuery();

        if (!empty($this->getDefaultRelations())) {
            $q = $q->with($this->getDefaultRelations());
        }

        foreach ($fields as $key => $value) {
            if (is_null($value))
                continue;
            $q = $q->where($key, $value);
        }

        return $q->get();
    }

    public function isUpToDate(IBaseModel $baseModel, array $data): bool
    {
        /** @var Model $baseModel */
        $fillable = $baseModel->getFillable();

        foreach ($data as $key => $value) {
            if (!in_array($key, $fillable))
                continue;

            if ($baseModel->{$key} != $value)
                return false;
        }
        return true;
    }

    public function update(IBaseModel $baseModel, array $data): ?IBaseModel
    {
        $baseModel->fill($data);

        if (!$baseModel->isDirty())
            return null;

        $baseModel->save();
        return $baseModel;
    }

    public function delete(IBaseModel $baseModel): bool
    {
        /** @var Model $baseModel */
        return $baseModel->delete();
    }

    public function pluckByColumn(string $col, array $data, string $pluckValuesCol, string $pluckKeysCol = null): Collection
    {
        $q = $this->model->whereIn($col, $data);

        if ($pluckKeysCol)
            return $q->pluck($pluckValuesCol, $pluckKeysCol);

        return $q->pluck($pluckValuesCol);
    }


}
