<?php

namespace App\Contracts\Auth;

use App\DTO\Response\Auth\LoginResponseDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;

interface IAuthService
{
    public function loginWith(string $loginService, array $fields): LoginResponseDTO;

    public function register(array $fields): ModelResponseDTO;

    public function logout(IUserModel $user, array $fields): ModelResponseDTO;
}
