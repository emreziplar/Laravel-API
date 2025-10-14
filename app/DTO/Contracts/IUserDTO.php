<?php

namespace App\DTO\Contracts;

use App\Models\Contracts\IUserModel;
use Illuminate\Support\Collection;

interface IUserDTO extends IDTO
{
    public function getUser(): IUserModel|Collection|null;
}
