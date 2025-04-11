<?php

namespace App\UseCases\DeleteProduct;

use App\UseCases\DeleteProduct\Request;
use App\UseCases\DeleteProduct\Response;
use  App\Services\ProductService;

class UseCase
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $deleted = $this->service->delete($request->input('id'));

        $response = new Response();
        $response->setStatus($deleted ? 'success' : 'failed');
        $response->setMessage($deleted ? '刪除成功' : '刪除失敗');

        return $response;
    }
}
