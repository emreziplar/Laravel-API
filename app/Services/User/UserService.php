<?php

namespace App\Services\User;

use App\Contracts\User\IUserService;
use App\DTO\Response\BaseResponseDTO;
use App\Repositories\Contracts\User\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    protected IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data): BaseResponseDTO
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if ($user)
            return new BaseResponseDTO(null, __t('user.exists'));

        $user = $this->userRepository->create($data);
        if (!$user)
            return new BaseResponseDTO(null, __t('user.not_created'));

        return new BaseResponseDTO($user, __t('user.created'));
    }

    public function get(array $fields): BaseResponseDTO
    {
        $users = $this->userRepository->getWithConditions($fields);
        if ($users->isEmpty())
            return new BaseResponseDTO(null, __t('user.not_found'));

        return new BaseResponseDTO($users, __t('user.found'));
    }

    public function update(int $id, array $data): BaseResponseDTO
    {
        $user = $this->userRepository->getFirst($id);
        if (!$user)
            return new BaseResponseDTO(null, __t('user.not_found'));

        if ($this->userRepository->isUpToDate($user, $data))
            return new BaseResponseDTO(null, __t('user.up_to_date'));

        $user = $this->userRepository->update($user, $data);

        return new BaseResponseDTO($user ?? null, $user ? __t('user.updated') : __t('user.not_updated'));
    }

    public function delete(int $id): BaseResponseDTO
    {
        $user = $this->userRepository->getFirst($id);
        if (!$user)
            return new BaseResponseDTO(null, __t('user.not_found'));

        $is_deleted = $this->userRepository->delete($user);

        return new BaseResponseDTO($is_deleted ? collect() : null, $is_deleted ? __t('user.deleted') : __t('user.not_deleted'));
    }
}
