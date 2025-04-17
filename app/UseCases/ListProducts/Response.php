<?php

namespace App\UseCases\ListProducts;

use App\Entities\Product;

class Response
{
    protected ?array $products = null;
    protected ?array $pagination = null;

    public function setProducts(array $products): void
    {
        $this->products = array_map(function (Product $product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getProps()->getName(),
                'description' => $product->getProps()->getDescription(),
                'price' => $product->getProps()->getPrice(),
            ];
        }, $products, []);
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
