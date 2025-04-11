<?php

namespace Tests\Unit\Factories;

use App\Factories\ProductFactory;
use App\Entities\Product as ProductEntity;
use App\Entities\Props\ProductProps;
use Tests\TestCase;

class ProductFactoryTest extends TestCase
{
    /**
     * 測試創建單一產品
     */
    public function testCreate()
    {
        $productData = [
            'id' => 1,
            'name' => 'Test Product',
            'description' => 'This is a test product.',
            'price' => 10.99,
        ];

        $productEntity = ProductFactory::create($productData);

        $this->assertInstanceOf(ProductEntity::class, $productEntity);
        $this->assertEquals(1, $productEntity->getId());

        $productProps = $productEntity->getProps();
        $this->assertInstanceOf(ProductProps::class, $productProps);
        $this->assertEquals('Test Product', $productProps->getName());
        $this->assertEquals('This is a test product.', $productProps->getDescription());
        $this->assertEquals(10.99, $productProps->getPrice());
    }

    /**
     * 測試批量創建產品
     */
    public function testBulk()
    {
        $productsData = [
            [
                'id' => 1,
                'name' => 'Product 1',
                'description' => 'Description 1',
                'price' => 10.99,
            ],
            [
                'id' => 2,
                'name' => 'Product 2',
                'description' => 'Description 2',
                'price' => 11.99,
            ],
        ];

        $productEntities = ProductFactory::bulk($productsData);

        $this->assertIsArray($productEntities);
        $this->assertCount(2, $productEntities);

        foreach ($productEntities as $index => $productEntity) {
            $this->assertInstanceOf(ProductEntity::class, $productEntity);
            $this->assertEquals($index + 1, $productEntity->getId());

            $productProps = $productEntity->getProps();
            $this->assertInstanceOf(ProductProps::class, $productProps);
            $this->assertEquals("Product " . ($index + 1), $productProps->getName());
            $this->assertEquals("Description " . ($index + 1), $productProps->getDescription());
            $this->assertEquals(10.99 + $index, $productProps->getPrice());
        }
    }
}
