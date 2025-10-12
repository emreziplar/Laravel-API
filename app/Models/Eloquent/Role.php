<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\IRoleModel;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements IRoleModel
{
    protected $table = 'roles';

    protected $fillable = ['role'];

    public function toResourceArray(): array
    {
        return[
            'id' => $this->id,
            'role' => $this->role
        ];
    }
}
