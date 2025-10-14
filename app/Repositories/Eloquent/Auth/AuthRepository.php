<?php

namespace App\Repositories\Eloquent\Auth;

use App\Models\Contracts\IUserModel;
use App\Models\Eloquent\User;
use App\Repositories\Contracts\Auth\IAuthRepository;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements IAuthRepository
{
    public function findByEmail(string $email): ?User
    {
        return User::where('email', $email)->first();
    }

    /** @var User $user */
    public function createToken(IUserModel $user, string $token_name = 'auth_token'): string
    {
        return $user->createToken($token_name)->plainTextToken;
    }

    public function createUser(array $data): ?User
    {
        return User::query()->create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /** @var User $user */
    public function deleteCurrentToken(IUserModel $user): bool
    {
        return $user->currentAccessToken()->delete();
    }

    /** @var User $user */
    public function deleteAllTokens(IUserModel $user): bool
    {
        return $user->tokens()->delete();
    }
}
