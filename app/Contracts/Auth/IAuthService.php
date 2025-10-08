<?php

namespace App\Contracts\Auth;

use App\DTO\Contracts\ILoginDTO;

interface IAuthService
{
    public function login(array $data): ILoginDTO;
}
