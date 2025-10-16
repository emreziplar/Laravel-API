<?php

namespace App\Repositories\Contracts\Role;


use App\Models\Contracts\IRoleModel;
use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Support\Collection;


/**
 * @extends IBaseRepository<IRoleModel>
 */
interface IRoleRepository extends IBaseRepository
{
    public function getByRoleName(string $role_name): ?IRoleModel;

    public function getPermissionNamesOfRole(IRoleModel $roleModel): Collection;

    public function isPermissionOfRole(IRoleModel $roleModel, string $permission_name): bool;

    public function assignPermissions(IRoleModel $roleModel, array $permissionIds): array;

    public function revokePermissions(IRoleModel $roleModel, array $permissionIds): array;
}
