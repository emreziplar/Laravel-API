<?php

namespace App\Services\Auth;

use App\Contracts\Auth\IAuthService;
use App\Contracts\Auth\ILoginService;
use App\DTO\Auth\SystemLoginResultDTO;
use App\DTO\Contracts\ILoginDTO;

class AuthService implements IAuthService
{

    private array $loginMap = [];

    public function __construct(private readonly iterable $loginServices)
    {
        foreach ($loginServices as $service) {
            if(!$service instanceof ILoginService) continue;
            $this->loginMap[$service->getType()] = $service;
        }
    }

    public function login(array $data): ILoginDTO
    {
        $type = $data['type'] ?? 'system';
        unset($data['type']);

        if (!isset($this->loginMap[$type])) {
            return new SystemLoginResultDTO(null, null, 'Invalid login type!');
        }

        return $this->loginMap[$type]->login($data);
    }
}
