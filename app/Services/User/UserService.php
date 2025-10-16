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
        $user = $this->userRepository->create($data);
        if(!$user)
            return new UserDTO(null,'User is not created!');

        return new UserDTO($user,'User is created successfully.');
    }

    public function get(array $fields): IDTO
    {
        $users = $this->userRepository->getWithConditions($fields);
        if($users->isEmpty())
            return new UserDTO(null,'Users not found!');

        return new UserDTO($users,'User(s) found.');
    }

    public function update(int $id, array $data): IDTO
    {
        $user = $this->userRepository->update($id,$data);

        return new UserDTO($user ?? null,$user ? 'User updated.' : 'User is not updated!');
    }

    public function delete(int $id): IDTO
    {
        $is_deleted = $this->userRepository->delete($id);

        return new UserDTO($is_deleted ? collect() : null,$is_deleted ? 'User is successfully deleted.' : 'User is not deleted!');
    }
}
