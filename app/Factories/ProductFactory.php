<?php

namespace App\Factories;

use App\Entities\Props\ProductProps;
use App\Entities\Product as ProductEntity;

class ProductFactory
{
    public static function create(array $product): ProductEntity
    {
        return new ProductEntity(
            $product['id'],
            new ProductProps(
                $product['name'],
                $product['description'],
                $product['price']
            )
        );
    }

    public static function bulk(array $products): array
    {
        return array_map(function ($product) {
            return self::create($product);
        }, $products);
    }
}
