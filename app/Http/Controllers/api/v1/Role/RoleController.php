<?php

namespace App\Http\Controllers\api\v1\Role;

use App\Contracts\Role\IRoleService;
use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\DeleteRoleRequest;
use App\Http\Requests\Role\GetRoleRequest;
use App\Http\Requests\Role\RolePermission\AssignPermissionRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    private const POLICY = 'rolePolicy';
    protected IRoleService $roleService;

    public function __construct(IRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function createRole(CreateRoleRequest $createRoleRequest)
    {
        $this->authorize('create',self::POLICY);

        $roleDTO = $this->roleService->create($createRoleRequest->validated());

        $roleData = $roleDTO->getRole();

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleData,
            $roleDTO->getMessage(),
            $this->toResource(RoleResource::class, $roleData),
            $roleData ? 201 : 409
        ));
    }

    public function getRole(GetRoleRequest $getRoleRequest)
    {
        $this->authorize('get',self::POLICY);

        $roleDTO = $this->roleService->get($getRoleRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleDTO->getRole(),
            $roleDTO->getMessage(),
            $this->toResource(RoleResource::class, $roleDTO->getRole())
        ));
    }

    public function updateRole(UpdateRoleRequest $updateRoleRequest)
    {
        $this->authorize('update',self::POLICY);

        $request = $updateRoleRequest->validated();

        $roleDTO = $this->roleService->update($request['id'], $request);

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleDTO->getRole(),
            $roleDTO->getMessage(),
            $this->toResource(RoleResource::class, $roleDTO->getRole())
        ));
    }

    public function deleteRole(DeleteRoleRequest $roleRequest)
    {
        $this->authorize('delete',self::POLICY);

        $request = $roleRequest->validated();

        $roleDTO = $this->roleService->delete($request['id']);

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleDTO->getRole(),
            $roleDTO->getMessage(),
            $this->toResource(RoleResource::class,$roleDTO->getRole()),
            $roleDTO->getRole() ? 200 : 404
        ));
    }

    public function assignPermission(AssignPermissionRequest $assignPermissionsRequest)
    {
        $this->authorize('assignPermission',self::POLICY);

        $roleDTO = $this->roleService->assignPermission($assignPermissionsRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleDTO->getRole(),
            $roleDTO->getMessage(),
            $this->toResource(RoleResource::class, $roleDTO->getRole())
        ));
    }

    public function revokePermission(AssignPermissionRequest $assignPermissionsRequest)
    {
        $this->authorize('revokePermission',self::POLICY);

        $roleDTO = $this->roleService->revokePermission($assignPermissionsRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleDTO->getRole(),
            $roleDTO->getMessage(),
            $this->toResource(RoleResource::class, $roleDTO->getRole())
        ));
    }
}
