<?php

namespace App\Models\Contracts;

interface IBlogModel extends IBaseModel
{
    public function getAuthorId();
}
