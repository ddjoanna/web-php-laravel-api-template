<?php

namespace App\UseCases\ListProducts;

class Response
{
    protected ?array $products = null;
    protected ?array $pagination = null;

    public function setProducts(array $data): void
    {
        $this->products = $data;
    }

    public function setPagination(array $pagination): void
    {
        $this->pagination = $pagination;
    }

    public function toArray(): array
    {
        return [
            'products' => $this->products,
            'pagination' => $this->pagination,
        ];
    }
}
