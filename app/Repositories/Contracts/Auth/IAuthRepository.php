<?php

namespace App\Repositories\Contracts\Auth;

use App\Models\User;

interface IAuthRepository
{
    public function findByEmail(string $email): ?User;

    public function createToken(User $user, string $token_name = 'auth_token'): string;
}
