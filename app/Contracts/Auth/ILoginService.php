<?php

namespace App\Contracts\Auth;

use App\DTO\Contracts\IDTO;

interface ILoginService
{
    public function login(array $fields): IDTO;
    public function getType(): string;
}
