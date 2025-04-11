<?php

namespace Tests\Unit\Entities;

use App\Entities\Props\ProductProps;
use Tests\TestCase;

class ProductPropsTest extends TestCase
{
    /**
     * 測試建構子
     */
    public function testConstructor()
    {
        $name = 'Test Product';
        $description = 'This is a test product';
        $price = 10.99;

        $productProps = new ProductProps($name, $description, $price);

        $this->assertEquals($name, $productProps->getName());
        $this->assertEquals($description, $productProps->getDescription());
        $this->assertEquals($price, $productProps->getPrice());
    }

    /**
     * 測試設置名稱
     */
    public function testSetName()
    {
        $productProps = new ProductProps('Initial Name', 'Description', 10.99);
        $newName = 'Updated Name';

        $productProps->setName($newName);

        $this->assertEquals($newName, $productProps->getName());
    }

    /**
     * 測試設置描述
     */
    public function testSetDescription()
    {
        $productProps = new ProductProps('Name', 'Initial Description', 10.99);
        $newDescription = 'Updated Description';

        $productProps->setDescription($newDescription);

        $this->assertEquals($newDescription, $productProps->getDescription());
    }

    /**
     * 測試設置價格
     */
    public function testSetPrice()
    {
        $productProps = new ProductProps('Name', 'Description', 10.99);
        $newPrice = 12.99;

        $productProps->setPrice($newPrice);

        $this->assertEquals($newPrice, $productProps->getPrice());
    }

    /**
     * 測試取得產品資料
     */
    public function testGetProduct()
    {
        $name = 'Test Product';
        $description = 'This is a test product';
        $price = 10.99;

        $productProps = new ProductProps($name, $description, $price);

        $expectedResult = [
            'name' => $name,
            'description' => $description,
            'price' => $price,
        ];

        $this->assertEquals($expectedResult, $productProps->getProduct());
    }
}
