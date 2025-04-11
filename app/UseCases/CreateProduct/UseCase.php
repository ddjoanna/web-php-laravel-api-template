<?php

namespace App\UseCases\CreateProduct;

use App\UseCases\CreateProduct\Request;
use App\UseCases\CreateProduct\Response;
use App\Services\ProductService;

class UseCase
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {

        $productVo = new \App\ValueObjects\ProductValueObject(
            $request->input('name'),
            $request->input('description'),
            $request->input('price')
        );

        $product = $this->service->create($productVo);
        $props = $product->getProps();

        $response = new Response();
        $response->setStatus('success');
        $response->setMessage('創建成功');
        $response->setData([
            'id' => $product->getId(),
            'name' => $props->getName(),
            'description' => $props->getDescription(),
            'price' => $props->getPrice(),
        ]);

        return $response;
    }
}
