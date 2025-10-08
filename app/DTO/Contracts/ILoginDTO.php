<?php

namespace App\DTO\Contracts;

use App\Models\User;

interface ILoginDTO extends IDTO
{
    public function getToken(): ?string;
    public function getUser(): ?User;
}
