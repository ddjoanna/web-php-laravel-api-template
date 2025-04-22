<?php

namespace App\Http\Controllers;

use App\Factories\ProductUseCaseFactory;
use App\UseCases\CreateProduct;
use App\UseCases\GetProduct;
use App\UseCases\ListProducts;
use App\UseCases\UpdateProduct;
use App\UseCases\DeleteProduct;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    protected ProductUseCaseFactory $productUseCaseFactory;

    public function __construct(ProductUseCaseFactory $productUseCaseFactory)
    {
        $this->productUseCaseFactory = $productUseCaseFactory;
    }

    public function index(ListProducts\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->productUseCaseFactory->makeListProductsUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    public function store(CreateProduct\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->productUseCaseFactory->makeCreateProductUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    public function show(GetProduct\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->productUseCaseFactory->makeGetProductUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    public function update(UpdateProduct\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->productUseCaseFactory->makeUpdateProductUseCase();
        $usecase->execute($request);
        return $response->success(204, 'success', null);
    }

    public function destroy(DeleteProduct\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->productUseCaseFactory->makeDeleteProductUseCase();
        $usecase->execute($request);
        return $response->success(204, 'success', null);
    }
}
