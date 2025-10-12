<?php

namespace App\Http\Controllers\api\v1\Role;

use App\Contracts\Role\IRoleService;
use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\CreateRoleRequest;
use App\Http\Requests\Role\DeleteRoleRequest;
use App\Http\Requests\Role\GetRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;
use App\Http\Resources\Role\RoleResource;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    protected IRoleService $roleService;

    public function __construct(IRoleService $roleService)
    {
        $this->roleService = $roleService;
    }

    public function createRole(CreateRoleRequest $createRoleRequest)
    {
        $role_dto = $this->roleService->create($createRoleRequest->validated());

        $roleData = $role_dto->getRole();

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$roleData,
            $role_dto->getMessage(),
            $this->toResource(RoleResource::class, $roleData),
            $roleData ? 201 : 409
        ));
    }

    public function getRole(GetRoleRequest $getRoleRequest)
    {
        $role_dto = $this->roleService->get($getRoleRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$role_dto,
            $role_dto->getMessage(),
            $this->toResource(RoleResource::class, $role_dto->getRole())
        ));
    }

    public function updateRole(UpdateRoleRequest $updateRoleRequest)
    {
        $request = $updateRoleRequest->validated();

        $role_dto = $this->roleService->update($request['id'], ['role' => $request['role']]);

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$role_dto->getRole(),
            $role_dto->getMessage(),
            $this->toResource(RoleResource::class, $role_dto->getRole())
        ));
    }

    public function deleteRole(DeleteRoleRequest $roleRequest)
    {
        $request = $roleRequest->validated();

        $role_dto = $this->roleService->delete($request['id']);

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$role_dto->getRole(),
            $role_dto->getMessage(),
            $this->toResource(RoleResource::class,$role_dto->getRole()),
            $role_dto->getRole() ? 200 : 404
        ));
    }
}
