<?php

namespace Tests\Unit\Repositories;

use App\Repositories\ProductRepository;
use App\Entities\Product as ProductEntity;
use App\Entities\Props\ProductProps;
use App\ValueObjects\ProductValueObject;
use App\Builders\ConditionsQueryBuilder;
use Tests\TestCase;
use Mockery;

class ProductRepositoryTest extends TestCase
{
    private ProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = Mockery::mock(ProductRepository::class);
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

        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn($productValueObject->getName());
        $productPropsMock->shouldReceive('getDescription')->andReturn($productValueObject->getDescription());
        $productPropsMock->shouldReceive('getPrice')->andReturn($productValueObject->getPrice());

        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn(1);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        $this->repository->shouldReceive('create')
            ->once()
            ->with($productValueObject)
            ->andReturn($productEntityMock);

        $result = $this->repository->create($productValueObject);

        $this->assertInstanceOf(ProductEntity::class, $result);
        $this->assertNotEmpty($result->getId());

        $product = $result->getProps();
        $this->assertInstanceOf(ProductProps::class, $product);
        $this->assertEquals($productValueObject->getName(), $product->getName());
        $this->assertEquals($productValueObject->getDescription(), $product->getDescription());
        $this->assertEquals($productValueObject->getPrice(), $product->getPrice());
    }

    /**
     * 測試查找產品
     */
    public function testFind()
    {
        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Test Product');
        $productPropsMock->shouldReceive('getDescription')->andReturn('This is a test product.');
        $productPropsMock->shouldReceive('getPrice')->andReturn(10.99);

        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn(1);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        $this->repository->shouldReceive('find')
            ->once()
            ->with(1)
            ->andReturn($productEntityMock);

        $result = $this->repository->find(1);

        $this->assertInstanceOf(ProductEntity::class, $result);
        $this->assertEquals(1, $result->getId());
        $this->assertEquals('Test Product', $result->getProps()->getName());
        $this->assertEquals('This is a test product.', $result->getProps()->getDescription());
        $this->assertEquals(10.99, $result->getProps()->getPrice());
    }

    /**
     * 測試更新產品
     */
    public function testUpdate()
    {
        $productEntityMock = Mockery::mock(ProductEntity::class);
        $productPropsMock = Mockery::mock(ProductProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Updated Product');
        $productPropsMock->shouldReceive('getDescription')->andReturn('Updated description');
        $productPropsMock->shouldReceive('getPrice')->andReturn(12.99);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

        $this->repository->shouldReceive('update')
            ->once()
            ->with($productEntityMock)
            ->andReturn(true);

        $result = $this->repository->update($productEntityMock);

        $this->assertTrue($result);
    }

    /**
     * 測試刪除產品
     */
    public function testDelete()
    {
        $this->repository->shouldReceive('delete')
            ->once()
            ->with(1)
            ->andReturn(true);

        $result = $this->repository->delete(1);

        $this->assertTrue($result);
    }

    /**
     * 測試列出產品
     */
    public function testList()
    {
        $products = [];
        for ($i = 1; $i <= 5; $i++) {
            $productPropsMock = Mockery::mock(ProductProps::class);
            $productPropsMock->shouldReceive('getName')->andReturn("Product $i");
            $productPropsMock->shouldReceive('getDescription')->andReturn("Description $i");
            $productPropsMock->shouldReceive('getPrice')->andReturn(10.99 + $i);

            $productEntityMock = Mockery::mock(ProductEntity::class);
            $productEntityMock->shouldReceive('getId')->andReturn($i);
            $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

            $products[] = $productEntityMock;
        }

        $conditionsQueryBuilder = new ConditionsQueryBuilder();

        $this->repository->shouldReceive('list')
            ->once()
            ->with($conditionsQueryBuilder)
            ->andReturn($products);

        $result = $this->repository->list($conditionsQueryBuilder);

        $this->assertIsArray($result);
        $this->assertCount(5, $result);
        foreach ($result as $product) {
            $this->assertInstanceOf(ProductEntity::class, $product);
        }
    }

    /**
     * 測試分頁
     */
    public function testPaginate()
    {
        $products = [];
        for ($i = 1; $i <= 5; $i++) {
            $productPropsMock = Mockery::mock(ProductProps::class);
            $productPropsMock->shouldReceive('getName')->andReturn("Product $i");
            $productPropsMock->shouldReceive('getDescription')->andReturn("Description $i");
            $productPropsMock->shouldReceive('getPrice')->andReturn(10.99 + $i);

            $productEntityMock = Mockery::mock(ProductEntity::class);
            $productEntityMock->shouldReceive('getId')->andReturn($i);
            $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);

            $products[] = $productEntityMock;
        }

        $pagination = [
            'page' => 1,
            'page_size' => 5,
            'total' => 10,
        ];

        $result = [
            'products' => $products,
            'pagination' => $pagination,
        ];

        $conditionsQueryBuilder = new ConditionsQueryBuilder();
        $conditionsQueryBuilder->setPage(1);
        $conditionsQueryBuilder->setPageSize(5);

        $this->repository->shouldReceive('paginate')
            ->once()
            ->with($conditionsQueryBuilder)
            ->andReturn($result);

        $actualResult = $this->repository->paginate($conditionsQueryBuilder);

        $this->assertIsArray($actualResult);
        $this->assertArrayHasKey('products', $actualResult);
        $this->assertArrayHasKey('pagination', $actualResult);
        $this->assertCount(5, $actualResult['products']);
        foreach ($actualResult['products'] as $product) {
            $this->assertInstanceOf(ProductEntity::class, $product);
        }
        $this->assertEquals(1, $actualResult['pagination']['page']);
        $this->assertEquals(5, $actualResult['pagination']['page_size']);
        $this->assertEquals(10, $actualResult['pagination']['total']);
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
