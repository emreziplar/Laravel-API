<?php

namespace App\Repositories\Eloquent\User;

use App\Models\Eloquent\User;
use App\Repositories\Contracts\User\IUserRepository;
use App\Repositories\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Hash;

class UserRepository extends BaseRepository implements IUserRepository
{
    protected function getModelClass()
    {
        return User::class;
    }

    public function create(array $data): mixed
    {
        $new_data = [
            'role_id' => $data['role_id'],
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => $data['password']
        ];
        if ($data['status'])
            $new_data['status'] = $data['status'];

        return $this->model->create($new_data);
    }

    public function update(int $id, array $data): mixed
    {
        $user = $this->getFirst($id);
        if (!$user)
            return false;

        $user->update($data);
        return $user;
    }
}
