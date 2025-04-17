<?php

namespace App\UseCases\CreateProduct;

use App\Entities\Product;

class Response
{
    protected ?array $product = null;

    public function setProduct(Product $product): void
    {
        $this->product = [
            'id' => $product->getId(),
            'name' => $product->getProps()->getName(),
            'description' => $product->getProps()->getDescription(),
            'price' => $product->getProps()->getPrice(),
        ];
    }

    public function toArray(): ?array
    {
        return $this->product;
    }
}
