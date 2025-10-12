<?php

namespace App\DTO\Contracts;

use App\Models\Contracts\IRoleModel;
use Illuminate\Support\Collection;

interface IRoleDTO extends IDTO
{
    public function getRole(): IRoleModel|Collection|null;
}
