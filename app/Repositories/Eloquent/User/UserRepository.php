<?php

namespace App\Repositories\Eloquent\User;

use App\Models\Contracts\IUserModel;
use App\Models\Eloquent\User;
use App\Repositories\Contracts\User\IUserRepository;
use App\Repositories\Eloquent\BaseEloquentRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseEloquentRepository implements IUserRepository
{
    protected function getModelClass()
    {
        return User::class;
    }

    public function findByEmail(string $email): ?IUserModel
    {
        /** @var User|null $user */
        $user = $this->getFirst($email, 'email');
        return $user;
    }
}
