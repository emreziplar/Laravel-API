<?php

namespace App\DTO\User;

use App\DTO\Contracts\IUserDTO;
use App\Models\Contracts\IUserModel;
use Illuminate\Support\Collection;

final class UserDTO implements IUserDTO
{
    private readonly IUserModel|Collection|null $user;
    private readonly string $message;

    /**
     * @param IUserModel|Collection|null $user
     * @param string $message
     */
    public function __construct(IUserModel|Collection|null $user, string $message)
    {
        $this->user = $user;
        $this->message = $message;
    }


    public function getMessage(): string
    {
        return $this->message;
    }


    public function getUser(): IUserModel|Collection|null
    {
       return $this->user;
    }
}
