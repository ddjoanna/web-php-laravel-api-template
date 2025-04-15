<?php

namespace App\UseCases\GetProduct;

class Response
{
    protected ?array $product = null;

    public function setProduct(array $product): void
    {
        $this->product = $product;
    }

    public function toArray(): array
    {
        return $this->product;
    }
}
