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

    public function execute(Request $request): Response
    {
        $product = ProductFactory::create($request->all());
        $updated = $this->service->update($product);

        $response = new Response();
        $response->setStatus($updated ? 'success' : 'failed');
        $response->setMessage($updated ? '更新成功' : '更新失敗');

        return $response;
    }
}
