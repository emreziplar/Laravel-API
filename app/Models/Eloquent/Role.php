<?php

namespace App\Models\Eloquent;

use App\Models\Contracts\IRoleModel;
use Illuminate\Database\Eloquent\Model;

class Role extends Model implements IRoleModel
{
    protected $table = 'roles';

    protected $fillable = ['role'];

    public function getId(): int
    {
        return $this->id;
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_permissions', 'role_id', 'permission_id');
    }
}
