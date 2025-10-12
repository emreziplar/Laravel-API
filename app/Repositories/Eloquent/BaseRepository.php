<?php

namespace App\Repositories\Eloquent;

use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

abstract class BaseRepository implements IBaseRepository
{
    /** @var Model */
    protected Model $model;

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
        return $this->getModelClass()::all();
    }

    public function get(int|string $data, string $col = 'id'): mixed
    {
        return $this->model::query()->where($col, $data)->first();
    }

    public function delete(int $id): bool
    {
        if (!$this->get($id))
            return false;

        return $this->model::query()->where('id', $id)->delete();
    }

}
