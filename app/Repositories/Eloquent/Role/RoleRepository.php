<?php

namespace App\Repositories\Eloquent\Role;

use App\Models\Eloquent\Role;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Repositories\Eloquent\BaseRepository;

/**
 * @property Role $model
 */
class RoleRepository extends BaseRepository implements IRoleRepository
{
    protected function getModelClass()
    {
        return Role::class;
    }

    public function create(array $data): mixed
    {
        $role_name = $data['role'];

        if($this->get($role_name,'role'))
            return false;

        return $this->model->query()->create([
            'role' => $role_name,
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        if (!$this->get($id)) {
            return false;
        }

        $permission = $this->model::query()->find($id);
        $permission->update(['role' => $data['role']]);
        return $permission;
    }
}
