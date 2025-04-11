<?php

namespace App\Factories;

use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\UseCases\CreateProduct\UseCase as CreateProductUseCase;
use App\UseCases\UpdateProduct\UseCase as UpdateProductUseCase;
use App\UseCases\DeleteProduct\UseCase as DeleteProductUseCase;
use App\UseCases\GetProduct\UseCase as GetProductUseCase;
use App\UseCases\ListProducts\UseCase as ListProductsUseCase;

class ProductUseCaseFactory
{
    protected ProductRepository $product_repository;
    protected ProductService $product_service;

    public function __construct(ProductRepository $product_repository, ProductService $product_service)
    {
        $this->product_repository = $product_repository;
        $this->product_service = $product_service;
    }

    public function makeCreateProductUseCase(): CreateProductUseCase
    {
        return new CreateProductUseCase($this->product_service);
    }

    public function makeUpdateProductUseCase(): UpdateProductUseCase
    {
        return new UpdateProductUseCase($this->product_service);
    }

    public function makeDeleteProductUseCase(): DeleteProductUseCase
    {
        return new DeleteProductUseCase($this->product_service);
    }

    public function makeGetProductUseCase(): GetProductUseCase
    {
        return new GetProductUseCase($this->product_service);
    }

    public function makeListProductsUseCase(): ListProductsUseCase
    {
        return new ListProductsUseCase($this->product_service);
    }
}
