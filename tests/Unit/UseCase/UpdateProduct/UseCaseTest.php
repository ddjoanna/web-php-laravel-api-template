<?php
// tests/Unit/UseCases/UpdateProduct/UseCaseTest.php

namespace Tests\Unit\UseCases\UpdateProduct;

use App\UseCases\UpdateProduct\Request;
use App\UseCases\UpdateProduct\Response;
use App\UseCases\UpdateProduct\UseCase;
use App\Services\ProductService;
use App\Factories\ProductFactory;
use App\Entities\Product as ProductEntity;
use Carbon\Factory;
use Mockery;
use Tests\TestCase;

class UseCaseTest extends TestCase
{
    protected UseCase $useCase;
    protected $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock ProductService
        $this->serviceMock = Mockery::mock(ProductService::class);

        // Create UseCase instance with mock service
        $this->useCase = new UseCase($this->serviceMock);
    }

    /**
     * 測試更新產品成功
     */
    public function testExecuteSuccess()
    {
        $request = new Request();
        $request->merge([
            'id' => 1,
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.99,
        ]);

        // Mock update method of ProductService
        $this->serviceMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(true);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals([
            'status' => 'success',
            'message' => '更新成功',
            'data' => null,
        ], $response->toArray());
    }

    /**
     * 測試更新產品失敗
     */
    public function testExecuteFailure()
    {
        $request = new Request();
        $request->merge([
            'id' => 1,
            'name' => 'Test Product',
            'description' => 'This is a test product',
            'price' => 10.99,
        ]);

        // Mock update method of ProductService
        $this->serviceMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(false);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals([
            'status' => 'failed',
            'message' => '更新失敗',
            'data' => null,
        ], $response->toArray());
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
