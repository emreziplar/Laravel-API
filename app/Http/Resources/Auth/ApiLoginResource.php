<?php

namespace App\Http\Resources\Auth;

use App\Http\Resources\User\UserResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ApiLoginResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'access_token' => $this->resource['token'],
            'user' => new UserResource($this->resource['user']),
        ];
    }
}
