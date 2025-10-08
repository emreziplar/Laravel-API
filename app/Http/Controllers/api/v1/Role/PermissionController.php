<?php

namespace App\Http\Controllers\api\v1\Role;

use App\Contracts\Role\IPermissionService;
use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Permission\CreatePermissionRequest;
use App\Http\Requests\Role\Permission\DeletePermissionRequest;
use App\Http\Requests\Role\Permission\GetPermissionRequest;
use App\Http\Requests\Role\Permission\UpdatePermissionRequest;
use App\Http\Resources\Role\PermissionResource;

class PermissionController extends Controller
{

    protected IPermissionService $permissionService;

    public function __construct(IPermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    public function createPermission(CreatePermissionRequest $permissionRequest)
    {
        $permission_dto = $this->permissionService->createPermission($permissionRequest->validated());

        $permission = $permission_dto->getPermission();

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$permission,
            $permission_dto->getMessage(),
            $permission ? $this->toResource(PermissionResource::class, $permission) : null,
            $permission ? 201 : 409
        ));
    }

    public function getPermission(GetPermissionRequest $permissionRequest)
    {
        $permission_dto = $this->permissionService->getPermission($permissionRequest->validated());

        $msg = $permission_dto->getMessage();
        $data = $this->toResource(PermissionResource::class, $permission_dto->getPermission());
        return $this->getHttpResponse(new ResponseDTO((bool)$data, $msg, $data));
    }

    public function updatePermission(UpdatePermissionRequest $updatePermissionRequest)
    {
        $request = $updatePermissionRequest->validated();

        $permission_dto = $this->permissionService->updatePermission($request['id'], $request['name']);

        $msg = $permission_dto->getMessage();
        $data = $this->toResource(PermissionResource::class, $permission_dto->getPermission());
        $success = (bool)$data;
        return $this->getHttpResponse(new ResponseDTO($success, $msg, $data));
    }

    public function deletePermission(DeletePermissionRequest $permissionRequest)
    {
        $request = $permissionRequest->validated();

        $permission_dto = $this->permissionService->deletePermission($request['id']);

        $msg = $permission_dto->getMessage();
        $data = $this->toResource(PermissionResource::class, $permission_dto->getPermission());
        $success = (bool)$data;
        return $this->getHttpResponse(new ResponseDTO($success, $msg, $data, $success ? 200 : 404));
    }
}
