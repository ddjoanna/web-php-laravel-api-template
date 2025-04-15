<?php
// tests/Unit/UseCases/ListProducts/UseCaseTest.php

namespace Tests\Unit\UseCases\ListProducts;

use App\UseCases\ListProducts\Request;
use App\UseCases\ListProducts\Response;
use App\UseCases\ListProducts\UseCase;
use App\Services\ProductService;
use App\Builders\ConditionsQueryBuilder;
use App\Entities\Product as ProductEntity;
use App\Entities\Props\ProductProps;
use Mockery;
use Tests\TestCase;

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
     * 測試列出產品成功
     */
    public function testExecuteSuccess()
    {
        $request = new Request();
        $request->merge([
            'page' => 1,
            'page_size' => 10,
            'order_by' => 'created_at',
            'order_direction' => 'desc',
        ]);

        // Mock ProductProps
        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Test Product');
        $productPropsMock->shouldReceive('getDescription')->andReturn('This is a test product.');
        $productPropsMock->shouldReceive('getPrice')->andReturn(10.99);

        // Mock ProductEntity
        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn(1);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        // Mock fetchPaginatedData method of ProductService
        $pagination = [
            'page' => 1,
            'page_size' => 10,
            'total' => 20,
        ];
        $result = [
            'products' => [$productEntityMock],
            'pagination' => $pagination,
        ];
        $this->serviceMock
            ->shouldReceive('fetchPaginatedData')
            ->once()
            ->andReturn($result);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertIsArray($response->toArray());
        $this->assertCount(1, $response->toArray()['products']);
        $this->assertEquals(1, $response->toArray()['products'][0]['id']);
        $this->assertEquals('Test Product', $response->toArray()['products'][0]['name']);
        $this->assertEquals('This is a test product.', $response->toArray()['products'][0]['description']);
        $this->assertEquals(10.99, $response->toArray()['products'][0]['price']);
        $this->assertIsArray($response->toArray()['pagination']);
        $this->assertEquals(1, $response->toArray()['pagination']['page']);
        $this->assertEquals(10, $response->toArray()['pagination']['page_size']);
    }

    /**
     * 測試列出產品帶關鍵字
     */
    public function testExecuteWithKeyword()
    {
        $request = new Request();
        $request->merge([
            'page' => 1,
            'page_size' => 10,
            'order_by' => 'created_at',
            'order_direction' => 'desc',
            'keyword' => 'Test Product',
        ]);

        // Mock ProductProps
        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Test Product');
        $productPropsMock->shouldReceive('getDescription')->andReturn('This is a test product.');
        $productPropsMock->shouldReceive('getPrice')->andReturn(10.99);

        // Mock ProductEntity
        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn(1);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        // Mock fetchPaginatedData method of ProductService
        $pagination = [
            'page' => 1,
            'page_size' => 10,
            'total' => 20,
        ];
        $result = [
            'products' => [$productEntityMock],
            'pagination' => $pagination,
        ];
        $this->serviceMock
            ->shouldReceive('fetchPaginatedData')
            ->once()
            ->andReturn($result);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertIsArray($response->toArray()['products']);
        $this->assertCount(1, $response->toArray()['products']);
        $this->assertEquals(1, $response->toArray()['products'][0]['id']);
        $this->assertEquals('Test Product', $response->toArray()['products'][0]['name']);
        $this->assertEquals('This is a test product.', $response->toArray()['products'][0]['description']);
        $this->assertEquals(10.99, $response->toArray()['products'][0]['price']);
        $this->assertIsArray($response->toArray()['pagination']);
        $this->assertEquals(1, $response->toArray()['pagination']['page']);
        $this->assertEquals(10, $response->toArray()['pagination']['page_size']);
        $this->assertEquals(20, $response->toArray()['pagination']['total']);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
