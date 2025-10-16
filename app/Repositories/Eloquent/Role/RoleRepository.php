<?php

namespace App\Repositories\Eloquent\Role;

use App\Models\Contracts\IRoleModel;
use App\Models\Eloquent\Role;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Collection;


class RoleRepository extends BaseRepository implements IRoleRepository
{
    protected function getModelClass()
    {
        return Role::class;
    }

    public function assignPermissions(IRoleModel $roleModel, array $permissionIds): array
    {
        $result = $roleModel->permissions()->syncWithoutDetaching($permissionIds);

        return [
            'processed_count' => count($result['attached']),
            'processed_ids' => $result['attached']
        ];
    }

    public function revokePermissions(IRoleModel $roleModel, array $permissionIds): array
    {
        $count = $roleModel->permissions()->detach($permissionIds);

        return [
            'processed_count' => $count,
            'processed_ids' => $count > 0 ? $permissionIds : []
        ];
    }

    public function getPermissionNamesOfRole(IRoleModel $roleModel): Collection
    {
        /** @var Role $roleModel */
        return $roleModel->permissions()->pluck('name');
    }

    public function isPermissionOfRole(IRoleModel $roleModel, string $permission_name): bool
    {
        return (bool)$roleModel->permissions()->where('name', $permission_name)->first();
    }

    public function getByRoleName(string $role_name): ?IRoleModel
    {
        /** @var Role|null $role */
        $role = $this->getFirst($role_name, 'role');
        return $role;
    }
}
