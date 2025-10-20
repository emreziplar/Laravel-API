<?php

namespace App\Repositories\Eloquent\Role;

use App\Models\Contracts\IPermissionModel;
use App\Models\Eloquent\Permission;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Collection;

class PermissionRepository extends BaseEloquentRepository implements IPermissionRepository
{
    protected function getModelClass()
    {
        return Permission::class;
    }

    public function getWithConditions(array $fields = []): Collection
    {
        $q = $this->model;

        foreach ($fields as $key => $value) {
            if (is_null($value))
                continue;
            $q = match ($key) {
                'name' => $q->whereLike('name', $value . '.%'),
                'ability' => $q->whereLike('name', '%.' . $value),
                default => $q->where($key, $value)
            };
        }

        return $q->get();
    }

    public function getByName(string $name): ?IPermissionModel
    {
        /** @var Permission|null $permission */
        $permission = $this->getFirst($name, 'name');
        return $permission;
    }

    public function pluckByName(array $permission_names): Collection
    {
        return $this->pluckByColumn('name', $permission_names, 'name');
    }

    public function getIdsByNames(array $permission_names): Collection
    {
        return $this->pluckByColumn('name',$permission_names,'id');
    }
}
