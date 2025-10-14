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
        return $this->model->create([
            'role' => $data['role'],
        ]);
    }

    public function update(int $id, array $data): mixed
    {
        $role = $this->getFirst($id);
        if (!$role) {
            return false;
        }

        $role->update(['role' => $data['role']]);
        return $role;
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
        $role = $this->getFirst($role_id);
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

        return ['current_role' => $role, 'processed_permissions' => $processed];
    }

    public function isPermissionOfRole(int $role_id, string $permission_name): bool
    {
        /** @var Role $role */
        $role = $this->getFirst($role_id);
        if (!$role)
            return false;

        $role_permission = $role->permissions()->where('name',$permission_name)->first();
        if(!$role_permission)
            return false;

        return true;
    }
}
