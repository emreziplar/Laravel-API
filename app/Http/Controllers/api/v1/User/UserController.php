<?php

namespace App\Http\Controllers\api\v1\User;

use App\Contracts\User\IUserService;
use App\DTO\ResponseDTO;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\CreateUserRequest;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\GetUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    private const POLICY = 'userPolicy';
    protected IUserService $userService;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
    }

    public function createUser(CreateUserRequest $createUserRequest)
    {
        $this->authorize('create', self::POLICY);

        $userDTO = $this->userService->create($createUserRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$userDTO->getData(),
            $userDTO->getMessage(),
            $this->toResource(UserResource::class, $userDTO->getData()),
            (bool)$userDTO->getData() ? 201 : 500
        ));
    }

    public function getUser(GetUserRequest $getUserRequest)
    {
        $this->authorize('get', self::POLICY);

        $userDTO = $this->userService->get($getUserRequest->validated());

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$userDTO->getData(),
            $userDTO->getMessage(),
            $this->toResource(UserResource::class, $userDTO->getData())
        ));
    }

    public function updateUser(UpdateUserRequest $updateUserRequest)
    {
        $this->authorize('update', self::POLICY);

        $req = $updateUserRequest->validated();
        $userDTO = $this->userService->update($req['id'], $req);

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$userDTO->getData(),
            $userDTO->getMessage(),
            $this->toResource(UserResource::class, $userDTO->getData())
        ));
    }

    public function deleteUser(DeleteUserRequest $deleteUserRequest)
    {
        $this->authorize('delete', self::POLICY);

        $req = $deleteUserRequest->validated();
        $userDTO = $this->userService->delete($req['id']);

        return $this->getHttpResponse(new ResponseDTO(
            (bool)$userDTO->getData(),
            $userDTO->getMessage(),
            null
        ));
    }
}
