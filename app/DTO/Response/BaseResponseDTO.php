<?php

namespace App\DTO\Response;

use App\Models\Contracts\IBaseModel;
use Illuminate\Support\Collection;

class BaseResponseDTO
{
    //TODO: add helper methods for http responses
    //TODO: refactor return types

    protected readonly IBaseModel|Collection|null $data;
    protected readonly string $message;

    public function __construct(Collection|IBaseModel|null $data, string $message)
    {
        $this->data = $data;
        $this->message = $message;
    }

    public function getData(): IBaseModel|Collection|null
    {
        return $this->data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }
}
