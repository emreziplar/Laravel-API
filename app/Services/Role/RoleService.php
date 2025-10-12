<?php

namespace App\Services\Role;

use App\Contracts\Role\IRoleService;
use App\DTO\Contracts\IRoleDTO;
use App\DTO\Role\RoleDTO;
use App\Repositories\Contracts\Role\IRoleRepository;
use Illuminate\Support\Collection;

class RoleService implements IRoleService
{
    protected IRoleRepository $roleRepository;

    public function __construct(IRoleRepository $roleRepository)
    {
        $this->roleRepository = $roleRepository;
    }

    public function create(array $data): IRoleDTO
    {
        $role = $this->roleRepository->create($data);

        if (!$role)
            return new RoleDTO(null, 'Role is not created!');

        return new RoleDTO($role, 'Role is successfully created!');
    }

    public function get(array $filters): IRoleDTO
    {
        $id = $filters['id'] ?? null;
        $role = $filters['role'] ?? null;

        $roleRepo = $this->roleRepository;
        $roleRepo->withPermissions();

        if ($id) {
            $role = $roleRepo->get($id);
        } elseif ($role) {
            $role = $roleRepo->get($role, 'role');
        } else {
            $role = $roleRepo->all();
        }

        if ($role instanceof Collection) {
            $found = $role->isNotEmpty();
        } else {
            $found = $role !== null;
        }

        return new RoleDTO($found ? $role : null, $found ? 'Role(s) found.' : 'Role not found!');
    }

    public function update(int $id, array $data): IRoleDTO
    {
        $roleRepo = $this->roleRepository;
        $roleRepo->withPermissions();
        $role = $roleRepo->update($id, $data);

        return new RoleDTO($role ? $role : null, $role ? 'Role updated!' : 'Role is not updated!');
    }

    public function delete(int $id): IRoleDTO
    {
        $role_deleted = $this->roleRepository->delete($id);

        $roleData = $role_deleted ? collect() : null;

        return new RoleDTO($roleData, $role_deleted ? 'Role is successfully deleted!' : 'Role is not deleted!');
    }

    public function assignPermission(array $data): IRoleDTO
    {
        $role_id = $data['role_id'] ?? null;
        $permissions = $data['permissions'] ?? null;

        $result = $this->roleRepository->assignPermissions($role_id, $permissions);

        if (empty($result['processed_permissions']))
            return new RoleDTO(null, 'Permission(s) is not assigned or already exists!');

        return new RoleDTO($result['current_role'], 'Permission(s) is successfully assigned.');
    }

    public function revokePermission(array $data): IRoleDTO
    {

        $role_id = $data['role_id'] ?? null;
        $permissions = $data['permissions'] ?? null;

        $result = $this->roleRepository->revokePermissions($role_id, $permissions);
        if (empty($result['processed_permissions']))
            return new RoleDTO(null, 'Permission(s) is not revoked or not found!');

        return new RoleDTO($result['current_role'], 'Permission(s) is successfully revoked.');

    }
}
