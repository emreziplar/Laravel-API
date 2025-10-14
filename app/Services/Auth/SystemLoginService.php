<?php

namespace App\Services\Auth;

use App\Contracts\Auth\ILoginService;
use App\DTO\Auth\AuthDTO;
use App\Repositories\Contracts\Auth\IAuthRepository;
use Illuminate\Support\Facades\Hash;

class SystemLoginService implements ILoginService
{
    private IAuthRepository $authRepository;

    public function __construct(IAuthRepository $authRepository)
    {
        $this->authRepository = $authRepository;
    }

    public function login(array $fields): AuthDTO
    {
        $req_email = $fields['email'];
        $req_password = $fields['password'];

        $user = $this->authRepository->findByEmail($req_email);

        if (!$user || !Hash::check($req_password, $user->password))
            return new AuthDTO(null, null, 'Email and password do not match!');

        $token = $this->authRepository->createToken($user);

        return new AuthDTO($token, $user, 'Login Successful!');
    }

    public function getType(): string
    {
        return 'system';
    }
}
