<?php

namespace App\Repositories\Contracts\Role;


use App\Models\Contracts\IRoleModel;
use App\Repositories\Contracts\IBaseRepository;


/**
 * @extends IBaseRepository<IRoleModel>
 */
interface IRoleRepository extends IBaseRepository
{
    public function assignPermissions(int $role_id, array $permission_names);

    public function revokePermissions(int $role_id, array $permission_names);

    public function isPermissionOfRole(int $role_id, string $permission_name): bool;
}
