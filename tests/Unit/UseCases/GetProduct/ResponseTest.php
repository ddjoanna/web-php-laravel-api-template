<?php

namespace Tests\Unit\UseCases\GetProduct;

use PHPUnit\Framework\TestCase;
use App\UseCases\GetProduct\Response;
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

    public function testSetProduct()
    {
        $data = [
            'id' => 1,
            'name' => '標題',
            'description' => '描述',
            'price' => 10.99
        ];

        $entity = new Product($data['id'], new ProductProps(
            $data['name'],
            $data['description'],
            $data['price']
        ));
        $this->response->setProduct($entity);
        $this->assertEquals($data, $this->response->toArray());
    }

    public function testHandleEmptyData()
    {
        $this->assertEquals(null, $this->response->toArray());
    }
}
