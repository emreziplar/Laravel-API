<?php

namespace App\Services\Auth;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Auth\ILoginService;
use App\DTO\Auth\AuthDTO;
use App\DTO\Contracts\IAuthDTO;
use App\Models\Contracts\IUserModel;
use App\Repositories\Contracts\Auth\IAuthRepository;

class AuthService implements IAuthService
{
    private IAuthRepository $authRepository;

    private array $loginMap = [];

    public function __construct(private readonly iterable $loginServices, IAuthRepository $authRepository)
    {
        $this->setLoginServices($this->loginServices);
        $this->authRepository = $authRepository;
    }

    private function setLoginServices($loginServices)
    {
        foreach ($loginServices as $service) {
            if (!$service instanceof ILoginService) continue;
            $this->loginMap[$service->getType()] = $service;
        }
    }

    public function login(array $fields): IAuthDTO
    {
        $type = $fields['type'] ?? 'system';
        unset($fields['type']);

        if (!isset($this->loginMap[$type])) {
            return new AuthDTO(null, null, 'Invalid login type!');
        }

        return $this->loginMap[$type]->login($fields);
    }

    public function register(array $fields): IAuthDTO
    {
        $is_user = $this->authRepository->findByEmail($fields['email']);
        if ($is_user)
            return new AuthDTO(null, null, 'Register failed!');

        $new_user = $this->authRepository->createUser($fields);
        if (!$new_user)
            return new AuthDTO(null, null, 'Register failed. System Error!');

        $user_token = $this->authRepository->createToken($new_user);
        if (!$user_token)
            return new AuthDTO(null, null, 'Register failed. Logical Error!');

        return new AuthDTO($user_token, $new_user, 'Register successful.');
    }

    public function logout(IUserModel $user, array $fields): IAuthDTO
    {
        $logout_all = $fields['logout_all'] ?? null;

        $msg = 'Logout failed!';
        if ($logout_all) {
            $is_logout = $this->authRepository->deleteAllTokens($user);
            if ($is_logout)
                $msg = 'Successfully logged out from all devices.';
        } else {
            $is_logout = $this->authRepository->deleteCurrentToken($user);
            if ($is_logout)
                $msg = 'Successfully logged out.';
        }

        return new AuthDTO(null, null, $msg);
    }
}
