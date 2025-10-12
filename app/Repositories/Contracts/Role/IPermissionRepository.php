<?php

namespace App\Repositories\Contracts\Role;

use App\Models\Contracts\IPermissionModel;
use App\Repositories\Contracts\IBaseRepository;
use Illuminate\Support\Collection;

/**
 * @extends IBaseRepository<IPermissionModel>
 */
interface IPermissionRepository extends IBaseRepository
{
    public function getPermissionByPrefixOrSuffix(string $prefix = null, string $suffix = null): Collection;

    public function withRoles(): IPermissionRepository;
}
