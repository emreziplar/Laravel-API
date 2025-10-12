<?php

namespace App\Repositories\Contracts;

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
    public function create(array $data): mixed;

    /**
     * @param int|string $data
     * @param string $col
     * @return TModel|null
     */
    public function get(int|string $data, string $col = 'id'): mixed;

    /**
     * @return Collection<int, TModel>
     */
    public function all(): Collection;

    /**
     * @param int $id
     * @param array $data
     * @return TModel|bool|null
     */
    public function update(int $id, array $data): mixed;

    public function delete(int $id): bool;

    public function pluckByColumn(string $col, array $data, string $pluckVal, string $pluckKey = null): mixed;
}
