<?php

namespace App\UseCases\RegisterUser;

use App\Interfaces\ApiResponse;

class Response implements ApiResponse
{
    protected string $status = '';
    protected string $message = '';
    protected array $data = [];

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
        ];
    }
}
