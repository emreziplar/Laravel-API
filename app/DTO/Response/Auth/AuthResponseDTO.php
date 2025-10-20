<?php

namespace App\DTO\Response\Auth;

use App\Models\Contracts\IUserModel;

final class AuthResponseDTO
{
    private readonly ?string $token;
    private readonly ?IUserModel $user;
    private readonly string $message;

    /**
     * @param string|null $token
     * @param IUserModel|null $user
     * @param string $message
     */
    public function __construct(?string $token, ?IUserModel $user, string $message = '')
    {
        $this->token = $token;
        $this->user = $user;
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @return IUserModel|null
     */
    public function getUser(): ?IUserModel
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
