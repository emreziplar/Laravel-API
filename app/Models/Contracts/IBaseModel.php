<?php

namespace App\Models\Contracts;

interface IBaseModel
{
    public function toResourceArray(): array;
}
