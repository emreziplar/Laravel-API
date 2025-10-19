<?php

namespace App\Models\Contracts;

interface ICategoryModel extends IBaseModel
{
    public function translation();

    public function translations();

    public function parent();

    public function children();

}
