<?php

namespace App\Repositories\Contracts\Auth;

use App\Models\Contracts\IUserModel;

interface IAuthRepository
{
    public function findByEmail(string $email): ?IUserModel;

    public function createToken(IUserModel $user, string $token_name = 'auth_token'): string;

    public function createUser(array $data): ?IUserModel;

    public function deleteCurrentToken(IUserModel $user): bool;

    public function deleteAllTokens(IUserModel $user): bool;
}
