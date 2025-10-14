<?php

namespace App\DTO\Contracts;

use App\Models\Contracts\IUserModel;

interface IAuthDTO extends IDTO
{
    public function getToken(): ?string;
    public function getUser(): ?IUserModel;
}
