<?php

namespace App\DTO\Response;

use App\Models\Contracts\IBaseModel;
use Illuminate\Support\Collection;

class ModelResponseDTO
{
    protected readonly IBaseModel|Collection|null $data;
    protected readonly string $message;
    protected readonly int $statusCode;

    public function __construct(Collection|IBaseModel|null $data, string $message, int $statusCode = 200)
    {
        $this->data = $data;
        $this->message = $message;
        $this->statusCode = $statusCode;
    }

    public function getData(): IBaseModel|Collection|null
    {
        return $this->data;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    public function isSuccess(): bool
    {
        return $this->getStatusCode() < 400;
    }
}
