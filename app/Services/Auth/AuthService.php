<?php

namespace App\Services\Auth;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Auth\ILoginService;
use App\DTO\Contracts\IAuthDTO;
use App\DTO\Response\Auth\LoginResponseDTO;
use App\DTO\Response\ModelResponseDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Auth\IAuthRepository;
use App\Repositories\Contracts\User\IUserRepository;

class AuthService implements IAuthService
{
    private IAuthRepository $authRepository;
    private IUserRepository $userRepository;

    private array $loginMap = [];

    public function __construct(private readonly iterable $loginServices, IAuthRepository $authRepository, IUserRepository $userRepository)
    {
        $this->setLoginServices($this->loginServices);
        $this->authRepository = $authRepository;
        $this->userRepository = $userRepository;
    }

    private function setLoginServices($loginServices)
    {
        foreach ($loginServices as $service) {
            if (!$service instanceof ILoginService)
                continue;
            $this->loginMap[$service->getLoginServiceName()] = $service;
        }
    }

    public function loginWith(string $loginService, array $fields): LoginResponseDTO
    {
        if (!isset($this->loginMap[$loginService])) {
            return new LoginResponseDTO(null, null, __t('auth.invalid_login_service'));
        }

        return $this->loginMap[$loginService]->login($fields);
    }

    public function register(array $fields): ModelResponseDTO
    {
        $isUser = $this->userRepository->findByEmail($fields['email']);
        if ($isUser)
            return new ModelResponseDTO(null, __t('auth.register_failed'), 409);

        $createdUser = $this->userRepository->create($fields);
        if (!$createdUser)
            return new ModelResponseDTO(null, __t('auth.register_failed_system'), 500);

        return new ModelResponseDTO($createdUser, __t('auth.register_success'), 201);
    }

    public function logout(IUserModel $user, array $fields): ModelResponseDTO
    {
        $logout_all = $fields['logout_all'] ?? null;

        $msg = __t('auth.logout_failed');
        if ($logout_all) {
            $is_logout = $this->authRepository->deleteAllTokens($user);
            if ($is_logout)
                $msg = __t('auth.logout_all_success');
        } else {
            $is_logout = $this->authRepository->deleteCurrentToken($user);
            if ($is_logout)
                $msg = __t('auth.logout_success');
        }

        return new ModelResponseDTO(null, $msg, $is_logout ? 200 : 500);
    }
}
