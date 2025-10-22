<?php

namespace App\Http\Controllers\api\v1\Role;

use App\Contracts\Role\IRoleService;
use App\DTO\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\DeleteRoleRequest;
use App\Http\Requests\Role\GetRoleRequest;
use App\Http\Requests\Role\RolePermission\AssignPermissionRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleResource;
use Dedoc\Scramble\Attributes\Endpoint;

class RoleController extends Controller
{
    private const POLICY = 'rolePolicy';
    protected IRoleService $roleService;

    public function __construct(IRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    #[Endpoint('Create Role')]
    public function createRole(CreateRoleRequest $createRoleRequest)
    {
        $this->authorize('create',self::POLICY);

        $modelResponseDTO = $this->roleService->create($createRoleRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, RoleResource::class);
    }

    #[Endpoint('Get Role')]
    public function getRole(GetRoleRequest $getRoleRequest)
    {
        $this->authorize('get',self::POLICY);

        $modelResponseDTO = $this->roleService->get($getRoleRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, RoleResource::class);
    }

    #[Endpoint('Update Role')]
    public function updateRole(UpdateRoleRequest $updateRoleRequest)
    {
        $this->authorize('update',self::POLICY);

        $requestData = $updateRoleRequest->validated();

        $modelResponseDTO = $this->roleService->update($requestData['id'], $requestData);

        return $this->respondWithModelDTO($modelResponseDTO, RoleResource::class);
    }

    #[Endpoint('Delete Role')]
    public function deleteRole(DeleteRoleRequest $roleRequest)
    {
        $this->authorize('delete',self::POLICY);

        $requestData = $roleRequest->validated();

        $modelResponseDTO = $this->roleService->delete($requestData['id']);

        return $this->respondWithModelDTO($modelResponseDTO, RoleResource::class);
    }

    public function assignPermission(AssignPermissionRequest $assignPermissionsRequest)
    {
        $this->authorize('assignPermission',self::POLICY);

        $modelResponseDTO = $this->roleService->assignPermission($assignPermissionsRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, RoleResource::class);
    }

    public function revokePermission(AssignPermissionRequest $assignPermissionsRequest)
    {
        $this->authorize('revokePermission',self::POLICY);

        $modelResponseDTO = $this->roleService->revokePermission($assignPermissionsRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, RoleResource::class);
    }
}
