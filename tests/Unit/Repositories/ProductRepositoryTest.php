<?php

namespace Tests\Unit\Repositories;

use App\Repositories\ProductRepository;
use App\Entities\Product as ProductEntity;
use App\Entities\Props\ProductProps;
use App\ValueObjects\ProductValueObject;
use App\Builders\ConditionsQueryBuilder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Product;
use Tests\TestCase;

class ProductRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private ProductRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(ProductRepository::class);
    }

    public function testCreate()
    {
        $productValueObject = new ProductValueObject(
            'Test Product',
            'This is a test product',
            10.99
        );
        $product = $this->repository->create($productValueObject);

        $this->assertInstanceOf(ProductEntity::class, $product);
        $this->assertNotEmpty($product->getId());

        $productProps = $product->getProps();
        $this->assertInstanceOf(ProductProps::class, $productProps);
        $this->assertEquals('Test Product', $productProps->getName());
        $this->assertEquals('This is a test product', $productProps->getDescription());
        $this->assertEquals(10.99, $productProps->getPrice());
    }

    public function testFind()
    {
        $product = Product::factory()->create();

        $entity = $this->repository->find($product->id);

        $this->assertInstanceOf(ProductEntity::class, $entity);
        $this->assertEquals(1, $entity->getId());
        $this->assertEquals($product->name, $entity->getProps()->getName());
        $this->assertEquals($product->description, $entity->getProps()->getDescription());
        $this->assertEquals($product->price, $entity->getProps()->getPrice());
    }

    public function testUpdate()
    {
        $product = Product::factory()->create();

        $entity = $this->repository->find($product->id);
        $productProps = $entity->getProps();
        $productProps->setName('Updated Product');
        $productProps->setDescription('Updated description');
        $productProps->setPrice(12.99);

        $updatedProduct = $this->repository->update($entity);
        $this->assertTrue($updatedProduct);

        $entity = $this->repository->find($product->id);
        $this->assertEquals('Updated Product', $entity->getProps()->getName());
        $this->assertEquals('Updated description', $entity->getProps()->getDescription());
        $this->assertEquals(12.99, $entity->getProps()->getPrice());
    }

    public function testDelete()
    {
        $product = Product::factory()->create();

        $result = $this->repository->delete($product->id);

        $this->assertTrue($result);
        $this->assertNull($this->repository->find($product->id));
    }

    /**
     * 測試列出產品
     */
    public function testList()
    {
        Product::factory()->times(10)->create();

        $conditionsQueryBuilder = new ConditionsQueryBuilder();

        $products = $this->repository->list($conditionsQueryBuilder);

        $this->assertIsArray($products);
        $this->assertNotEmpty($products);
        foreach ($products as $product) {
            $this->assertInstanceOf(ProductEntity::class, $product);
        }
    }

    /**
     * 測試分頁
     */
    public function testPaginate()
    {
        $page = 1;
        $page_size = 5;
        $total = 10;
        Product::factory()->times($total)->create();

        $conditionsQueryBuilder = new ConditionsQueryBuilder();
        $conditionsQueryBuilder->setPage($page);
        $conditionsQueryBuilder->setPageSize($page_size);

        $result = $this->repository->paginate($conditionsQueryBuilder);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('products', $result);
        $this->assertArrayHasKey('pagination', $result);
        $this->assertCount(5, $result['products']);
        foreach ($result['products'] as $product) {
            $this->assertInstanceOf(ProductEntity::class, $product);
        }
        $this->assertEquals($page, $result['pagination']['page']);
        $this->assertEquals($page_size, $result['pagination']['page_size']);
        $this->assertEquals($total, $result['pagination']['total']);
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
