<?php

namespace App\Http\Controllers;

use App\Factories\ProductUseCaseFactory;
use App\UseCases\CreateProduct;
use App\UseCases\GetProduct;
use App\UseCases\ListProducts;
use App\UseCases\UpdateProduct;
use App\UseCases\DeleteProduct;

class ProductController extends Controller
{
    protected ProductUseCaseFactory $productUseCaseFactory;

    public function __construct(ProductUseCaseFactory $productUseCaseFactory)
    {
        $this->productUseCaseFactory = $productUseCaseFactory;
    }
    public function index(ListProducts\Request $request)
    {
        $usecase = $this->productUseCaseFactory->makeListProductsUseCase();
        $response = $usecase->execute($request);
        return response()->json($response->toArray(), 200);
    }

    public function store(CreateProduct\Request $request)
    {
        $usecase = $this->productUseCaseFactory->makeCreateProductUseCase();
        $response = $usecase->execute($request);
        return response()->json($response->toArray(), 201);
    }

    public function show(GetProduct\Request $request)
    {
        $usecase = $this->productUseCaseFactory->makeGetProductUseCase();
        $response = $usecase->execute($request);
        return response()->json($response->toArray(), 200);
    }

    public function update(UpdateProduct\Request $request)
    {
        $usecase = $this->productUseCaseFactory->makeUpdateProductUseCase();
        $usecase->execute($request);
        return response()->noContent();
    }

    public function destroy(DeleteProduct\Request $request)
    {
        $usecase = $this->productUseCaseFactory->makeDeleteProductUseCase();
        $usecase->execute($request);
        return response()->noContent();
    }
}
