<?php

namespace App\Repositories\Eloquent\Role;

use App\Models\Eloquent\Permission;
use App\Repositories\Contracts\Role\IPermissionRepository;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Collection;

class PermissionRepository extends BaseRepository implements IPermissionRepository
{
    protected function getModelClass()
    {
        return Permission::class;
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

    public function create(array $data): mixed
    {
        $permission_name = $data['name'];

        if ($this->get($permission_name, 'name'))
            return false;

        return $this->model::query()->create([
            'name' => $permission_name
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        if (!$this->get($id)) {
            return false;
        }

        $permission = $this->model::query()->find($id);
        $permission->update(['name' => $data['name']]);
        return $permission;
    }
}
