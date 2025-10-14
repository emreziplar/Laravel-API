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

    public function toResourceArray(): array
    {
        return [
            'id' => (int)$this->id,
            'name' => $this->name,
            'roles' =>  $this->roles?->pluck('role')
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_permissions', 'permission_id', 'role_id');
    }
}
