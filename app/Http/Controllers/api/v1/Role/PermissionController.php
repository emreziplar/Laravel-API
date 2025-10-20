<?php

namespace App\Http\Controllers\api\v1\Role;

use App\Contracts\Role\IPermissionService;
use App\DTO\Response\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\Role\Permission\CreatePermissionRequest;
use App\Http\Requests\Role\Permission\DeletePermissionRequest;
use App\Http\Requests\Role\Permission\GetPermissionRequest;
use App\Http\Requests\Role\Permission\UpdatePermissionRequest;
use App\Http\Resources\Role\PermissionResource;
use Dedoc\Scramble\Attributes\Endpoint;

class PermissionController extends Controller
{
    private const POLICY = 'permissionPolicy';
    protected IPermissionService $permissionService;

    public function __construct(IPermissionService $permissionService)
    {
        $this->permissionService = $permissionService;
    }

    #[Endpoint('Create Permission')]
    public function createPermission(CreatePermissionRequest $permissionRequest)
    {
        $this->authorize('create',self::POLICY);

        $permissionDTO = $this->permissionService->create($permissionRequest->validated());

        $permission = $permissionDTO->getData();

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$permission,
            $permissionDTO->getMessage(),
            $permission ? $this->toResource(PermissionResource::class, $permission) : null,
            $permission ? 201 : 409
        ));
    }

    #[Endpoint('Get Permission')]
    public function getPermission(GetPermissionRequest $permissionRequest)
    {
        $this->authorize('get', self::POLICY);

        $permissionDTO = $this->permissionService->get($permissionRequest->validated());

        $msg = $permissionDTO->getMessage();
        $data = $this->toResource(PermissionResource::class, $permissionDTO->getData());
        return $this->getHttpResponse(new ResponseDTO((bool)$data, $msg, $data));
    }

    #[Endpoint('Update Permission')]
    public function updatePermission(UpdatePermissionRequest $updatePermissionRequest)
    {
        $this->authorize('update', self::POLICY);

        $request = $updatePermissionRequest->validated();

        $permissionDTO = $this->permissionService->update($request['id'], ['name' => $request['name']]);

        $msg = $permissionDTO->getMessage();
        $data = $this->toResource(PermissionResource::class, $permissionDTO->getData());
        $success = (bool)$data;
        return $this->getHttpResponse(new ResponseDTO($success, $msg, $data));
    }

    #[Endpoint('Delete Permission')]
    public function deletePermission(DeletePermissionRequest $permissionRequest)
    {
        $this->authorize('delete', self::POLICY);

        $request = $permissionRequest->validated();

        $permissionDTO = $this->permissionService->delete($request['id']);

        $msg = $permissionDTO->getMessage();
        $data = $this->toResource(PermissionResource::class, $permissionDTO->getData());
        $success = (bool)$data;
        return $this->getHttpResponse(new ResponseDTO($success, $msg, $data, $success ? 200 : 404));
    }
}
