<?php

namespace App\Contracts\Auth;

use App\DTO\Contracts\IDTO;

interface IAuthService
{
    public function login(array $data): IDTO;
}
