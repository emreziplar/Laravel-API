<?php

namespace App\Repositories\Eloquent\Role;

use App\Models\Eloquent\Role;
use App\Repositories\Contracts\Role\IRoleRepository;
use App\Repositories\Eloquent\BaseRepository;


class RoleRepository extends BaseRepository implements IRoleRepository
{
    protected PermissionRepository $permissionRepository;

    public function __construct(PermissionRepository $permissionRepository)
    {
        parent::__construct();
        $this->permissionRepository = $permissionRepository;
    }

    protected function getModelClass()
    {
        return Role::class;
    }

    public function create(array $data): mixed
    {
        $role_name = $data['role'];

        if ($this->get($role_name, 'role'))
            return false;

        return $this->model->query()->create([
            'role' => $role_name,
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        $role = $this->get($id);
        if (!$role) {
            return false;
        }

        $role->update(['role' => $data['role']]);
        return $role;
    }

    public function withPermissions(): self
    {
        $this->model = $this->model->newQuery();
        $this->model->with('permissions');
        return $this;
    }

    public function assignPermissions(int $role_id, array $permission_names)
    {
        return $this->setPermissions($role_id,$permission_names,'assign');
    }

    public function revokePermissions(int $role_id, array $permission_names)
    {
        return $this->setPermissions($role_id,$permission_names,'revoke');
    }

    private function setPermissions(int $role_id, array $permission_names, string $type)
    {
        $role = $this->get($role_id);
        if (!$role)
            return false;

        $permission_ids = $this->permissionRepository->pluckByColumn('name', $permission_names, 'id');
        if ($permission_ids->isEmpty())
            return false;

        if ($type === 'assign') {
            $syncResult = $role->permissions()->syncWithoutDetaching($permission_ids);
            $processed = $syncResult['attached'];
        }
        elseif ($type === 'revoke') {
            $revokedCount = $role->permissions()->detach($permission_ids);
            $processed = $revokedCount > 0 ? $permission_ids : [];;
        }
        else
            return null;

        $role = $role->load('permissions');

        return ['current_role' => $role, 'processed_permissions' => $processed];
    }
}
