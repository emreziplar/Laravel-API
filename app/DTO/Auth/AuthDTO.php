<?php

namespace App\DTO\Auth;

use App\DTO\Contracts\IAuthDTO;
use App\Models\Contracts\IBaseModel;
use App\Models\Contracts\IUserModel;
use Illuminate\Support\Collection;

final class AuthDTO implements IAuthDTO
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

    public function getData(): IBaseModel|Collection|null
    {
        return collect(); //TODO: edit
    }
}
