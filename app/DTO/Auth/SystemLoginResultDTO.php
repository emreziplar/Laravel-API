<?php

namespace App\DTO\Auth;

use App\DTO\Contracts\IDTO;
use App\Models\User;

final class SystemLoginResultDTO implements IDTO
{
    private readonly ?string $token;
    private readonly ?User $user;
    private readonly string $message;

    /**
     * @param string|null $token
     * @param User|null $user
     * @param string $message
     */
    public function __construct(?string $token, ?User $user, string $message = '')
    {
        $this->token = $token;
        $this->user = $user;
        $this->message = $message;
    }

    public function toArray(): array
    {
        return [
            'token' => $this->token,
            'user' => $this->user?->toArray(),
            'message' => $this->message
        ];
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return User|null
     */
    public function getUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getMessage(): string
    {
        return $this->message;
    }

}
