<?php

namespace Tests\Unit\Entities;

use App\Entities\Product;
use App\Entities\Props\ProductProps;
use Tests\TestCase;

class ProductTest extends TestCase
{
    /**
     * 測試建構子
     */
    public function testConstructor()
    {
        $id = 1;
        $name = 'Test Product';
        $description = 'This is a test product';
        $price = 10.99;

        $productProps = new ProductProps($name, $description, $price);
        $product = new Product($id, $productProps);

        $this->assertEquals($id, $product->getId());
        $this->assertEquals($name, $product->getProps()->getName());
        $this->assertEquals($description, $product->getProps()->getDescription());
        $this->assertEquals($price, $product->getProps()->getPrice());
    }

    /**
     * 測試設置屬性
     */
    public function testSetProps()
    {
        $id = 1;
        $initialName = 'Initial Name';
        $initialDescription = 'Initial Description';
        $initialPrice = 10.99;

        $initialProps = new ProductProps($initialName, $initialDescription, $initialPrice);
        $product = new Product($id, $initialProps);

        $newName = 'Updated Name';
        $newDescription = 'Updated Description';
        $newPrice = 12.99;

        $newProps = new ProductProps($newName, $newDescription, $newPrice);
        $product->setProps($newProps);

        $this->assertEquals($newName, $product->getProps()->getName());
        $this->assertEquals($newDescription, $product->getProps()->getDescription());
        $this->assertEquals($newPrice, $product->getProps()->getPrice());
    }
}
