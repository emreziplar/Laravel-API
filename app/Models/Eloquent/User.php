<?php

namespace App\Models\Eloquent;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Contracts\IUserModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements IUserModel
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'status'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function toResourceArray(): array
    {
        return [
            'id' => (int)$this->id,
            'role_id' => (int)$this->role_id,
            'name' => $this->name,
            'email' => $this->email,
            'status' => (int)$this->status,
            'role' => $this->role?->toResourceArray(),
        ];
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function roleId(): int
    {
        return $this->role_id;
    }
}
