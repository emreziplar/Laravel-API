<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;


abstract class BaseRepository implements IBaseRepository
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

    abstract protected function getModelClass();

    public function all(): Collection
    {
        return $this->model->get();
    }

    public function get(int|string $data, string $col = 'id'): mixed
    {
        return $this->model->where($col, $data)->first();
    }

    public function delete(int $id): bool
    {
        if (!$this->get($id))
            return false;

        return $this->model->where('id', $id)->delete();
    }

    public function pluckByColumn(string $col, array $data, string $pluckVal, string $pluckKey = null): Collection
    {
        $q = $this->model->whereIn($col, $data);

        if ($pluckKey)
            return $q->pluck($pluckVal, $pluckKey);

        return $q->pluck($pluckVal);
    }


}
