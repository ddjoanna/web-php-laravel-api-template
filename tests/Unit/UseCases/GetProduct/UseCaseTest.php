<?php

namespace Tests\Unit\UseCases\GetProduct;

use App\UseCases\GetProduct\Request;
use App\UseCases\GetProduct\Response;
use App\UseCases\GetProduct\UseCase;
use App\Services\ProductService;
use App\Entities\Product as ProductEntity;
use App\Entities\Props\ProductProps;
use Mockery;
use Tests\TestCase;
use App\Exceptions\NotFoundException;

class UseCaseTest extends TestCase
{
    protected $serviceMock;
    protected UseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock ProductService
        $this->serviceMock = Mockery::mock(ProductService::class);

        // Create UseCase instance with mock service
        $this->useCase = new UseCase($this->serviceMock);
    }

    /**
     * 測試取得產品成功
     */
    public function testExecuteSuccess()
    {
        $productId = 1;

        // Mock ProductProps
        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Test Product');
        $productPropsMock->shouldReceive('getDescription')->andReturn('This is a test product.');
        $productPropsMock->shouldReceive('getPrice')->andReturn(10.99);

        // Mock ProductEntity
        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn($productId);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        // Mock find method of ProductService
        $this->serviceMock
            ->shouldReceive('find')
            ->once()
            ->with($productId)
            ->andReturn($productEntityMock);

        $request = new Request();
        $request->merge(['id' => $productId]);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertEquals([
            "id" => $productId,
            "name" => "Test Product",
            "description" => "This is a test product.",
            "price" => 10.99,
        ], $response->toArray());
    }

    /**
     * 測試取得產品失敗
     */
    public function testExecuteFailure()
    {
        $productId = 1;

        // Mock find method of ProductService
        $this->serviceMock
            ->shouldReceive('find')
            ->once()
            ->with($productId)
            ->andReturn(null);

        $request = new Request();
        $request->merge(['id' => $productId]);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Product not found');

        $this->useCase->execute($request);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
