<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\IPermissionModel;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model implements IPermissionModel
{
    protected $table = 'permissions';

    protected $fillable = [
        'name'
    ];

    public function getId(): int
    {
        return $this->id;
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
}
