<?php

namespace App\DTO\Contracts;

use App\Models\Contracts\IBaseModel;
use Illuminate\Support\Collection;

interface IDTO
{
    public function getMessage(): string;

    public function getData(): IBaseModel|Collection|null;
}
