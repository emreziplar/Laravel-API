<?php

namespace App\Repositories\Contracts\Role;

use App\Models\Permission;
use Illuminate\Support\Collection;

interface IPermissionRepository
{
    public function createPermission(array $data): Permission|bool;

    public function all(): Collection;

    public function getPermission(int|string $permission_data, $col = 'id'): ?Permission;

    public function getPermissionByPrefixOrSuffix(string $prefix = null, string $suffix = null): Collection;

    public function updatePermission(int $id, string $name): Permission|bool|null;

    public function deletePermission(int $id): bool;
}
