<?php

namespace App\Services\User;

use App\Contracts\User\IUserService;
use App\DTO\Contracts\IDTO;
use App\DTO\Contracts\IUserDTO;
use App\DTO\User\UserDTO;
use App\Repositories\Contracts\User\IUserRepository;
use Illuminate\Support\Facades\Hash;

class UserService implements IUserService
{
    protected IUserRepository $userRepository;

    public function __construct(IUserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function create(array $data): IUserDTO
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if ($user)
            return new UserDTO(null, __t('user.exists'));

        $user = $this->userRepository->create($data);
        if (!$user)
            return new UserDTO(null, __t('user.not_created'));

        return new UserDTO($user, __t('user.created'));
    }

    public function get(array $fields): IDTO
    {
        $users = $this->userRepository->getWithConditions($fields);
        if ($users->isEmpty())
            return new UserDTO(null, __t('user.not_found'));

        return new UserDTO($users, __t('user.found'));
    }

    public function update(int $id, array $data): IDTO
    {
        $user = $this->userRepository->getFirst($id);
        if (!$user)
            return new UserDTO(null, __t('user.not_found'));

        if ($this->userRepository->isUpToDate($user, $data))
            return new UserDTO(null, __t('user.up_to_date'));

        $user = $this->userRepository->update($user, $data);

        return new UserDTO($user ?? null, $user ? __t('user.updated') : __t('user.not_updated'));
    }

    public function delete(int $id): IDTO
    {
        $user = $this->userRepository->getFirst($id);
        if (!$user)
            return new UserDTO(null, __t('user.not_found'));

        $is_deleted = $this->userRepository->delete($user);

        return new UserDTO($is_deleted ? collect() : null, $is_deleted ? __t('user.deleted') : __t('user.not_deleted'));
    }
}
