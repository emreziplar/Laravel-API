<?php

namespace App\Models\Contracts;

interface ICategoryModel extends IBaseModel
{
    public function getParentId(): ?int;

    public function getFullPathAttribute(): string;
}
