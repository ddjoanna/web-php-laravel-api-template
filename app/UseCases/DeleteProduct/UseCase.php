<?php

namespace App\UseCases\DeleteProduct;

use App\UseCases\DeleteProduct\Request;
use App\Services\ProductService;

class UseCase
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): bool
    {
        return $this->service->delete($request->input('id'));
    }
}
