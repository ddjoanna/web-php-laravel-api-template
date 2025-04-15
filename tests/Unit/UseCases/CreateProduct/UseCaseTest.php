<?php

namespace Tests\Unit\UseCases\CreateProduct;

use App\UseCases\CreateProduct\Request;
use App\UseCases\CreateProduct\Response;
use App\UseCases\CreateProduct\UseCase;
use App\Services\ProductService;
use App\ValueObjects\ProductValueObject;
use App\Entities\Product as ProductEntity;
use App\Entities\Props\ProductProps;
use Tests\TestCase;
use Mockery;

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
     * 測試創建產品
     */
    public function testExecute()
    {
        $request = new Request();
        $request->merge([
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 10.99,
        ]);

        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Test Product');
        $productPropsMock->shouldReceive('getDescription')->andReturn('This is a test product.');
        $productPropsMock->shouldReceive('getPrice')->andReturn(10.99);

        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn(1);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        $this->serviceMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof ProductValueObject &&
                    $arg->getName() === 'Test Product' &&
                    $arg->getDescription() === 'This is a test product.' &&
                    $arg->getPrice() === 10.99;
            }))
            ->andReturn($productEntityMock);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertEquals([
            "id" => 1,
            "name" => "Test Product",
            "description" => "This is a test product.",
            "price" => 10.99,
        ], $response->toArray());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
