<?php

namespace Tests\Unit\Factories;

use App\Factories\ProductUseCaseFactory;
use App\Repositories\ProductRepository;
use App\Services\ProductService;
use App\UseCases\CreateProduct\UseCase as CreateProductUseCase;
use App\UseCases\UpdateProduct\UseCase as UpdateProductUseCase;
use App\UseCases\DeleteProduct\UseCase as DeleteProductUseCase;
use App\UseCases\GetProduct\UseCase as GetProductUseCase;
use App\UseCases\ListProducts\UseCase as ListProductsUseCase;
use PHPUnit\Framework\TestCase;

class ProductUseCaseFactoryTest extends TestCase
{
    protected ProductRepository $productRepository;
    protected ProductService $productService;
    protected ProductUseCaseFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock
        $this->productRepository = $this->createMock(ProductRepository::class);
        $this->productService = $this->createMock(ProductService::class);

        // 創建 factory 實例
        $this->factory = new ProductUseCaseFactory($this->productRepository, $this->productService);
    }

    public function testMakeCreateProductUseCase()
    {
        $useCase = $this->factory->makeCreateProductUseCase();

        $this->assertInstanceOf(CreateProductUseCase::class, $useCase);
    }

    public function testMakeUpdateProductUseCase()
    {
        $useCase = $this->factory->makeUpdateProductUseCase();

        $this->assertInstanceOf(UpdateProductUseCase::class, $useCase);
    }

    public function testMakeDeleteProductUseCase()
    {
        $useCase = $this->factory->makeDeleteProductUseCase();

        $this->assertInstanceOf(DeleteProductUseCase::class, $useCase);
    }

    public function testMakeGetProductUseCase()
    {
        $useCase = $this->factory->makeGetProductUseCase();

        $this->assertInstanceOf(GetProductUseCase::class, $useCase);
    }

    public function testMakeListProductsUseCase()
    {
        $useCase = $this->factory->makeListProductsUseCase();

        $this->assertInstanceOf(ListProductsUseCase::class, $useCase);
    }
}
