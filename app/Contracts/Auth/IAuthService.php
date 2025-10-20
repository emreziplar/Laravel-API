<?php

namespace App\Contracts\Auth;

use App\DTO\Response\Auth\AuthResponseDTO;
use App\Models\Contracts\IUserModel;

interface IAuthService
{
    public function redirectLogin(array $fields): AuthResponseDTO;

    public function register(array $fields): AuthResponseDTO;

    public function logout(IUserModel $user, array $fields): AuthResponseDTO;
}
