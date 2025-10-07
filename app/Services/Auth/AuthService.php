<?php

namespace App\Services\Auth;

use App\Contracts\Auth\IAuthService;
use App\DTO\Auth\SystemLoginResultDTO;
use App\DTO\Contracts\IDTO;

class AuthService implements IAuthService
{

    private array $loginMap = [];

    public function __construct(private readonly iterable $loginServices)
    {
        foreach ($loginServices as $service) {
            $this->loginMap[$service->getType()] = $service;
        }
    }

    public function login(array $data): IDTO
    {
        $type = $data['type'] ?? 'system';
        unset($data['type']);

        if (!isset($this->loginMap[$type])) {
            return new SystemLoginResultDTO(null, null, 'Invalid login type!');
        }

        return $this->loginMap[$type]->login($data);
    }
}
