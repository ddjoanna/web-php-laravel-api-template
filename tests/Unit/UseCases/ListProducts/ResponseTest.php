<?php

namespace Tests\Unit\UseCases\ListProducts;

use PHPUnit\Framework\TestCase;
use App\UseCases\ListProducts\Response;
use App\Entities\Product;
use App\Entities\Props\ProductProps;

class ResponseTest extends TestCase
{
    protected Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = new Response();
    }

    public function testSetProducts()
    {
        $products = [
            [
                'id' => 1,
                'name' => '標題1',
                'description' => '描述1',
                'price' => 10.99
            ],
            [
                'id' => 2,
                'name' => '標題2',
                'description' => '描述2',
                'price' => 10.99
            ]
        ];

        $entity = [];
        foreach ($products as $product) {
            $entity[] = new Product($product['id'], new ProductProps(
                $product['name'],
                $product['description'],
                $product['price']
            ));
        }
        $this->response->setProducts($entity);

        $this->assertEquals([
            'products' => $products,
            'pagination' => null,
        ], $this->response->toArray());
    }

    public function testSetPagination()
    {
        $pagination = [
            'page' => 1,
            'page_size' => 5,
            'total' => 0,
        ];
        $this->response->setPagination($pagination);
        $this->assertEquals([
            'products' => null,
            'pagination' => $pagination,
        ], $this->response->toArray());
    }

    public function testToArray()
    {
        $products = [
            [
                'id' => 1,
                'name' => '標題1',
                'description' => '描述1',
                'price' => 10.99
            ],
            [
                'id' => 2,
                'name' => '標題2',
                'description' => '描述2',
                'price' => 10.99
            ]
        ];

        $entity = [];
        foreach ($products as $product) {
            $entity[] = new Product($product['id'], new ProductProps(
                $product['name'],
                $product['description'],
                $product['price']
            ));
        }
        $this->response->setProducts($entity);

        $pagination = [
            'page' => 1,
            'page_size' => 5,
            'total' => 0,
        ];

        $this->response->setPagination($pagination);

        $expected = [
            'products' => $products,
            'pagination' => $pagination,
        ];

        $this->assertEquals($expected, $this->response->toArray());
    }

    public function testHandleEmptyData()
    {
        $this->assertEquals([
            'products' => null,
            'pagination' => null,
        ], $this->response->toArray());
    }
}
