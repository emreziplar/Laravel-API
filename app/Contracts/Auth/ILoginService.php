<?php

namespace App\Contracts\Auth;

use App\DTO\Response\Auth\AuthResponseDTO;

interface ILoginService
{
    public function login(array $fields): AuthResponseDTO;
    public function getType(): string;
}
