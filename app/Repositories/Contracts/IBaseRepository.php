<?php

namespace App\Repositories\Contracts;

use App\Models\Contracts\IBaseModel;
use Illuminate\Support\Collection;

/**
 * @template TModel of \App\Models\Contracts\IBaseModel
 */
interface IBaseRepository
{
    /**
     * @param array $data
     * @return TModel|bool
     */
    public function create(array $data): ?IBaseModel;

    /**
     * @param int|string $data
     * @param string $col
     * @return TModel|null
     */
    public function getFirst(int|string $data, string $col = 'id'): ?IBaseModel;

    /**
     * @param array $fields
     * @return Collection<int, TModel>
     */
    public function getWithConditions(array $fields = []): Collection;

    /**
     * @return Collection<int, TModel>
     */
    public function all(): Collection;

    public function isUpToDate(IBaseModel $baseModel, array $data): bool;

    public function update(IBaseModel $baseModel, array $data): ?IBaseModel;

    public function delete(IBaseModel $baseModel): bool;

    public function pluckByColumn(string $col, array $data, string $pluckValuesCol, string $pluckKeysCol = null): Collection;

    public function getModelClass(): string;
}
