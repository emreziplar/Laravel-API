<?php

namespace App\DTO\Contracts;

use App\Models\Contracts\IUserModel;

interface ILoginDTO extends IDTO
{
    public function getToken(): ?string;
    public function getUser(): ?IUserModel;
}
