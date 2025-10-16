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
    public function getByName(string $name): ?IPermissionModel;

    public function pluckByName(array $permission_names): Collection;

    public function getIdsByNames(array $permission_names): Collection;

}
