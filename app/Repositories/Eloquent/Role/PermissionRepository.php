<?php

namespace App\Repositories\Eloquent\Role;

use App\DTO\Contracts\IPermissionDTO;
use App\Models\Permission;
use App\Repositories\Contracts\Role\IPermissionRepository;
use Illuminate\Support\Collection;

class PermissionRepository implements IPermissionRepository
{

    public function createPermission(array $data): Permission|bool
    {
        $permission_name = $data['name'];

        if ($this->getPermission($permission_name, 'name'))
            return false;

        return Permission::query()->create([
            'name' => $permission_name
        ]);
    }

    public function getPermission(int|string $permission_data, $col = 'id'): ?Permission
    {
        return Permission::query()->where($col, $permission_data)->first();
    }

    public function getPermissionByPrefixOrSuffix(string $prefix = null, string $suffix = null): Collection
    {
        $q = Permission::query();

        if ($prefix)
            $q->whereLike('name', $prefix . '.%');

        if ($suffix)
            $q->whereLike('name', '%.' . $suffix);

        return $q->get();
    }

    public function updatePermission(int $id, string $name): Permission|bool|null
    {
        if (!$this->getPermission($id)) {
            return false;
        }

        $permission = Permission::query()->find($id);
        $permission->update(['name' => $name]);
        return $permission;
    }

    public function deletePermission(int $id): bool
    {
        if (!$this->getPermission($id))
            return false;

        return Permission::query()->where('id', $id)->delete();
    }

    public function all(): Collection
    {
        return Permission::all();
    }
}
