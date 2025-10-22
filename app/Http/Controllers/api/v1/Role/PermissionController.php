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

        $modelResponseDTO = $this->permissionService->create($permissionRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, PermissionResource::class);
    }

    #[Endpoint('Get Permission')]
    public function getPermission(GetPermissionRequest $permissionRequest)
    {
        $this->authorize('get', self::POLICY);

        $modelResponseDTO = $this->permissionService->get($permissionRequest->validated());

        return $this->respondWithModelDTO($modelResponseDTO, PermissionResource::class);
    }

    #[Endpoint('Update Permission')]
    public function updatePermission(UpdatePermissionRequest $updatePermissionRequest)
    {
        $this->authorize('update', self::POLICY);

        $requestData = $updatePermissionRequest->validated();
        $modelResponseDTO = $this->permissionService->update($requestData['id'], $requestData);

        return $this->respondWithModelDTO($modelResponseDTO, PermissionResource::class);
    }

    #[Endpoint('Delete Permission')]
    public function deletePermission(DeletePermissionRequest $permissionRequest)
    {
        $this->authorize('delete', self::POLICY);

        $requestData = $permissionRequest->validated();

        $modelResponseDTO = $this->permissionService->delete($requestData['id']);

        return $this->respondWithModelDTO($modelResponseDTO, PermissionResource::class);
    }
}
