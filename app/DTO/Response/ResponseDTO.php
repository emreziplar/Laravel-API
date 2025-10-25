<?php

namespace App\DTO\Response;

class ResponseDTO
{
    private bool $is_success;
    private string|array $message;
    private mixed $data;
    private int $status_code;

    /**
     * @param bool $is_success
     * @param string|array $message
     * @param mixed $data
     * @param int $status_code
     */
    public function __construct(bool $is_success, string|array $message, mixed $data, int $status_code = 200)
    {
        $this->is_success = $is_success;
        $this->message = $message;
        $this->data = $data;
        $this->status_code = $status_code;
    }

    /**
     * @return bool
     */
    public function isSuccess(): bool
    {
        return $this->is_success;
    }

    /**
     * @return string|array
     */
    public function getMessage(): string|array
    {
        return $this->message;
    }

    /**
     * @return mixed
     */
    public function getData(): mixed
    {
        return $this->data;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->status_code;
    }
}
