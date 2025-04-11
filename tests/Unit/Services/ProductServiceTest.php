<?php
// tests/Unit/Services/ProductServiceTest.php

namespace Tests\Unit\Services;

use App\Services\ProductService;
use App\Repositories\ProductRepository;
use App\ValueObjects\ProductValueObject;
use App\Entities\Product as ProductEntity;
use App\Builders\ConditionsQueryBuilder;
use App\Entities\Props\ProductProps;
use Mockery;
use Tests\TestCase;

class ProductServiceTest extends TestCase
{
    protected ProductService $service;
    protected $repositoryMock;

    protected function setUp(): void
    {
        parent::setUp();

        // 模擬 ProductRepository
        $this->repositoryMock = Mockery::mock(ProductRepository::class);

        // 使用模擬的 Repository 建立 ProductService 實例
        $this->service = new ProductService($this->repositoryMock);
    }

    /**
     * 測試創建產品
     */
    public function testCreate()
    {
        $productValueObject = new ProductValueObject(
            'Test Product',
            'This is a test product',
            10.99
        );

        // 模擬 ProductEntity
        $mockProductEntity = Mockery::mock(ProductEntity::class);
        $mockProductEntity->shouldReceive('getId')->andReturn(1);
        $mockProps = Mockery::mock(ProductProps::class);
        $mockProps->shouldReceive('getName')->andReturn('Test Product');
        $mockProps->shouldReceive('getDescription')->andReturn('This is a test product');
        $mockProps->shouldReceive('getPrice')->andReturn(10.99);
        $mockProductEntity->shouldReceive('getProps')->andReturn($mockProps);

        // 模擬 Repository 的 create 方法
        $this->repositoryMock
            ->shouldReceive('create')
            ->once()
            ->with($productValueObject)
            ->andReturn($mockProductEntity);

        $result = $this->service->create($productValueObject);

        $this->assertInstanceOf(ProductEntity::class, $result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals('Test Product', $result->getProps()->getName());
        $this->assertEquals('This is a test product', $result->getProps()->getDescription());
        $this->assertEquals(10.99, $result->getProps()->getPrice());
    }

    /**
     * 測試查找產品
     */
    public function testFind()
    {
        $id = 1;

        // 模擬 ProductEntity
        $mockProductEntity = Mockery::mock(ProductEntity::class);
        $mockProductEntity->shouldReceive('getId')->andReturn($id);
        $mockProps = Mockery::mock(ProductProps::class);
        $mockProps->shouldReceive('getName')->andReturn('Test Product');
        $mockProps->shouldReceive('getDescription')->andReturn('This is a test product');
        $mockProps->shouldReceive('getPrice')->andReturn(10.99);
        $mockProductEntity->shouldReceive('getProps')->andReturn($mockProps);

        // 模擬 Repository 的 find 方法
        $this->repositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn($mockProductEntity);

        $result = $this->service->find($id);

        $this->assertInstanceOf(ProductEntity::class, $result);
        $this->assertEquals($id, $result->getId());
        $this->assertEquals('Test Product', $result->getProps()->getName());
        $this->assertEquals('This is a test product', $result->getProps()->getDescription());
        $this->assertEquals(10.99, $result->getProps()->getPrice());
    }

    /**
     * 測試查找不存在的產品
     */
    public function testFindNonExistentProduct()
    {
        $id = 1;

        // 模擬 Repository 的 find 方法
        $this->repositoryMock
            ->shouldReceive('find')
            ->once()
            ->with($id)
            ->andReturn(null);

        $result = $this->service->find($id);

        $this->assertNull($result);
    }

    /**
     * 測試更新產品
     */
    public function testUpdate()
    {
        // 模擬 ProductEntity
        $mockProductEntity = Mockery::mock(ProductEntity::class);
        $mockProductEntity->shouldReceive('getId')->andReturn(1);
        $mockProps = Mockery::mock(ProductProps::class);
        $mockProps->shouldReceive('getName')->andReturn('Updated Product');
        $mockProps->shouldReceive('getDescription')->andReturn('Updated description');
        $mockProps->shouldReceive('getPrice')->andReturn(12.99);
        $mockProductEntity->shouldReceive('getProps')->andReturn($mockProps);

        // 模擬 Repository 的 update 方法
        $this->repositoryMock
            ->shouldReceive('update')
            ->once()
            ->with($mockProductEntity)
            ->andReturn(true);

        $result = $this->service->update($mockProductEntity);

        $this->assertTrue($result);
    }

    /**
     * 測試刪除產品
     */
    public function testDelete()
    {
        $id = 1;

        // 模擬 Repository 的 delete 方法
        $this->repositoryMock
            ->shouldReceive('delete')
            ->once()
            ->with($id)
            ->andReturn(true);

        $result = $this->service->delete($id);

        $this->assertTrue($result);
    }

    /**
     * 測試列出產品
     */
    public function testList()
    {
        $conditionsQueryBuilder = new ConditionsQueryBuilder();

        // 模擬 ProductEntity
        $mockProductEntity1 = Mockery::mock(ProductEntity::class);
        $mockProductEntity1->shouldReceive('getId')->andReturn(1);
        $mockProps1 = Mockery::mock(ProductProps::class);
        $mockProps1->shouldReceive('getName')->andReturn('Product 1');
        $mockProps1->shouldReceive('getDescription')->andReturn('Description 1');
        $mockProps1->shouldReceive('getPrice')->andReturn(10.99);
        $mockProductEntity1->shouldReceive('getProps')->andReturn($mockProps1);

        $mockProductEntity2 = Mockery::mock(ProductEntity::class);
        $mockProductEntity2->shouldReceive('getId')->andReturn(2);
        $mockProps2 = Mockery::mock(ProductProps::class);
        $mockProps2->shouldReceive('getName')->andReturn('Product 2');
        $mockProps2->shouldReceive('getDescription')->andReturn('Description 2');
        $mockProps2->shouldReceive('getPrice')->andReturn(12.99);
        $mockProductEntity2->shouldReceive('getProps')->andReturn($mockProps2);

        $expectedResult = [$mockProductEntity1, $mockProductEntity2];

        // 模擬 Repository 的 list 方法
        $this->repositoryMock
            ->shouldReceive('list')
            ->once()
            ->with($conditionsQueryBuilder)
            ->andReturn($expectedResult);

        $result = $this->service->list($conditionsQueryBuilder);

        $this->assertIsArray($result);
        $this->assertCount(2, $result);
        foreach ($result as $product) {
            $this->assertInstanceOf(ProductEntity::class, $product);
        }
    }

    /**
     * 測試分頁功能
     */
    public function testFetchPaginatedData()
    {
        $conditionsQueryBuilder = new ConditionsQueryBuilder();

        // 模擬 ProductEntity
        $mockProductEntity1 = Mockery::mock(ProductEntity::class);
        $mockProductEntity1->shouldReceive('getId')->andReturn(1);
        $mockProps1 = Mockery::mock(ProductProps::class);
        $mockProps1->shouldReceive('getName')->andReturn('Product 1');
        $mockProps1->shouldReceive('getDescription')->andReturn('Description 1');
        $mockProps1->shouldReceive('getPrice')->andReturn(10.99);
        $mockProductEntity1->shouldReceive('getProps')->andReturn($mockProps1);

        $mockProductEntity2 = Mockery::mock(ProductEntity::class);
        $mockProductEntity2->shouldReceive('getId')->andReturn(2);
        $mockProps2 = Mockery::mock(ProductProps::class);
        $mockProps2->shouldReceive('getName')->andReturn('Product 2');
        $mockProps2->shouldReceive('getDescription')->andReturn('Description 2');
        $mockProps2->shouldReceive('getPrice')->andReturn(12.99);
        $mockProductEntity2->shouldReceive('getProps')->andReturn($mockProps2);

        $expectedResult = [
            'products' => [$mockProductEntity1, $mockProductEntity2],
            'pagination' => [
                'page' => 1,
                'page_size' => 5,
                'total' => 10,
            ],
        ];

        // 模擬 Repository 的 paginate 方法
        $this->repositoryMock
            ->shouldReceive('paginate')
            ->once()
            ->with($conditionsQueryBuilder)
            ->andReturn($expectedResult);

        $result = $this->service->fetchPaginatedData($conditionsQueryBuilder);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('products', $result);
        $this->assertArrayHasKey('pagination', $result);
        $this->assertCount(2, $result['products']);
        foreach ($result['products'] as $product) {
            $this->assertInstanceOf(ProductEntity::class, $product);
        }
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
