<?php

namespace App\Contracts\Auth;

use App\DTO\Contracts\IDTO;

interface ILoginService
{
    public function login(array $data): IDTO;
    public function getType(): string;
}
