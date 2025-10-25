<?php

namespace App\Support\Validation;

use App\DTO\Response\ModelResponseDTO;

class ValidationResult
{
    public function __construct(
        private readonly bool              $isValid,
        private readonly string|array|null $message,
        private readonly ?int              $statusCode,
        private readonly mixed             $data = null
    )
    {
    }

    public static function success(mixed $data = null): self
    {
        return new self(isValid: true, message: null, statusCode: 200, data: $data);
    }

    public static function fail(string|array $message, int $statusCode = null): self
    {
        return new self(isValid: false, message: $message, statusCode: $statusCode);
    }

    public function get(string $key)
    {
        return is_array($this->data) && isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function getData(string $key = null)
    {
        return $key ? $this->get($key) : $this->data;
    }

    public function isValid(): bool
    {
        return $this->isValid;
    }

    public function toModelResponse(int $statusCode = null): ModelResponseDTO
    {
        return new ModelResponseDTO(
            data: $this->data,
            message: $this->message,
            statusCode: $this->statusCode ?? $statusCode
        );
    }

}
