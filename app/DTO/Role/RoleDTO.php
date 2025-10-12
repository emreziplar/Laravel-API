<?php

namespace App\DTO\Role;

use App\DTO\Contracts\IRoleDTO;
use App\Models\Contracts\IRoleModel;
use Illuminate\Support\Collection;

final class RoleDTO implements IRoleDTO
{
    private readonly IRoleModel|Collection|null $roleModel;
    private readonly string $message;

    /**
     * @param IRoleModel|Collection|null $roleModel
     * @param string $message
     */
    public function __construct(IRoleModel|Collection|null $roleModel, string $message)
    {
        $this->roleModel = $roleModel;
        $this->message = $message;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getRole(): IRoleModel|Collection|null
    {
        return $this->roleModel;
    }
}
