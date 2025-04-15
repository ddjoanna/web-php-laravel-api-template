<?php

namespace Tests\Unit\UseCases\ListProducts;

use PHPUnit\Framework\TestCase;
use App\UseCases\ListProducts\Response;

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
        $data = [
            ['id' => 1, 'title' => '標題1', 'description' => '描述1', 'price' => 10.99],
            ['id' => 2, 'title' => '標題2', 'description' => '描述2', 'price' => 10.99],
        ];
        $this->response->setProducts($data);
        $this->assertEquals([
            'products' => $data,
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
        $data = [
            ['id' => 1, 'title' => '標題1', 'description' => '描述1', 'price' => 10.99],
            ['id' => 2, 'title' => '標題2', 'description' => '描述2', 'price' => 10.99],
        ];

        $pagination = [
            'page' => 1,
            'page_size' => 5,
            'total' => 0,
        ];

        $this->response->setProducts($data);
        $this->response->setPagination($pagination);

        $expected = [
            'products' => $data,
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
