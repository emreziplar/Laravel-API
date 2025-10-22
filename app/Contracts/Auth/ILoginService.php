<?php

namespace App\Contracts\Auth;

use App\DTO\Response\Auth\LoginResponseDTO;

interface ILoginService
{
    public function login(array $fields): LoginResponseDTO;
    public function getLoginServiceName(): string;
}
