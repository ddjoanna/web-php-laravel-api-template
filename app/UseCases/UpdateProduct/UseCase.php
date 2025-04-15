<?php

namespace App\UseCases\UpdateProduct;

use App\UseCases\UpdateProduct\Request;
use App\UseCases\UpdateProduct\Response;
use App\Services\ProductService;
use App\Factories\ProductFactory;

class UseCase
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): bool
    {
        $product = ProductFactory::create($request->all());
        return $this->service->update($product);
    }
}
