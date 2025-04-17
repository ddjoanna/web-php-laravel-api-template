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

        $response = new Response();
        $response->setProduct($product);

        return $response;
    }
}
