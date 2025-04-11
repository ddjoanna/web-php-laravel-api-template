<?php

namespace App\UseCases\GetProduct;

use App\UseCases\GetProduct\Request;
use App\UseCases\GetProduct\Response;
use App\Services\ProductService;
use App\Exceptions\NotFoundException;

class UseCase
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $product = $this->service->find($request->input('id'));
        $response = new Response();
        if (!$product) {
            throw new NotFoundException('Product not found');
        }

        $props = $product->getProps();
        $response->setStatus('success');
        $response->setMessage('取得成功');
        $response->setData([
            'id' => $product->getId(),
            'name' => $props->getName(),
            'description' => $props->getDescription(),
            'price' => $props->getPrice(),
        ]);

        return $response;
    }
}
