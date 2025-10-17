<?php

namespace App\Services\Auth;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Auth\ILoginService;
use App\DTO\Auth\AuthDTO;
use App\DTO\Contracts\IAuthDTO;
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
            $this->loginMap[$service->getType()] = $service;
        }
    }

    public function login(array $fields): IAuthDTO
    {
        $type = $fields['type'] ?? 'system';
        unset($fields['type']);

        if (!isset($this->loginMap[$type])) {
            return new AuthDTO(null, null, __t('auth.invalid_type'));
        }

        return $this->loginMap[$type]->login($fields);
    }

    public function register(array $fields): IAuthDTO
    {
        $is_user = $this->userRepository->findByEmail($fields['email']);
        if ($is_user)
            return new AuthDTO(null, null, __t('auth.register_failed'));

        $new_user = $this->userRepository->create($fields);
        if (!$new_user)
            return new AuthDTO(null, null, __t('auth.register_failed_system'));

        $user_token = $this->authRepository->createToken($new_user);
        if (!$user_token)
            return new AuthDTO(null, null, __t('auth.register_failed_logic'));

        return new AuthDTO($user_token, $new_user, __t('auth.register_success'));
    }

    public function logout(IUserModel $user, array $fields): IAuthDTO
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

        return new AuthDTO(null, null, $msg);
    }
}
