<?php

namespace App\Repositories\Contracts\User;

use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\IBaseRepository;

interface IUserRepository extends IBaseRepository
{
    public function findByEmail(string $email): ?IUserModel;
}
