<?php

namespace App\Contracts\Auth;

use App\DTO\Contracts\IAuthDTO;
use App\Models\Contracts\IUserModel;

interface IAuthService
{
    public function login(array $fields): IAuthDTO;

    public function register(array $fields): IAuthDTO;

    public function logout(IUserModel $user, array $fields): IAuthDTO;
}
