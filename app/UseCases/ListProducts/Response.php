<?php

namespace App\UseCases\ListProducts;

use App\Interfaces\ApiResponse;

class Response implements ApiResponse
{
    protected ?string $status = null;
    protected ?string $message = null;
    protected ?array $data = null;
    protected ?array $pagination = null;

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function setStatus(string $status): void
    {
        $this->status = $status;
    }

    public function setData(?array $data): void
    {
        $this->data = $data;
    }

    public function setPagination(?array $pagination): void
    {
        $this->pagination = $pagination;
    }

    public function toArray(): array
    {
        return [
            'status' => $this->status,
            'message' => $this->message,
            'data' => [
                'products' => $this->data,
                'pagination' => $this->pagination,
            ],
        ];
    }
}
