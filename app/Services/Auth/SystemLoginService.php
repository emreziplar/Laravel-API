<?php

namespace App\Services\Auth;

use App\Contracts\Auth\ILoginService;
use App\DTO\Auth\AuthDTO;
use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\User\IUserRepository;
use Illuminate\Support\Facades\Hash;

class SystemLoginService implements ILoginService
{
    private IAuthRepository $authRepository;
    private IUserRepository $userRepository;


    public function __construct(IAuthRepository $authRepository, IUserRepository $userRepository)
    {
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    public function login(array $fields): AuthDTO
    {
        $req_email = $fields['email'];
        $req_password = $fields['password'];

        $user = $this->userRepository->findByEmail($req_email);
        if (!$user || !Hash::check($req_password, $user->password))
            return new AuthDTO(null, null, __t('auth.failed'));

        $token = $this->authRepository->createToken($user);

        return new AuthDTO($token, $user, __t('auth.login_successful'));
    }

    public function getType(): string
    {
        return 'system';
    }
}
