<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\Contracts\IUserModel;
use App\Models\Eloquent\User;
use App\Repositories\Contracts\Auth\IAuthRepository;

class AuthRepository implements IAuthRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    public function createToken(IUserModel $user, string $token_name = 'auth_token'): string
    {
        return $user->createToken($token_name)->plainTextToken;
    }
}
