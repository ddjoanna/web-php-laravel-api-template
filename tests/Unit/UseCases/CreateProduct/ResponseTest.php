<?php

namespace Tests\Unit\UseCases\CreateProduct;

use PHPUnit\Framework\TestCase;
use App\UseCases\CreateProduct\Response;

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
        $data = ['id' => 1, 'title' => '標題', 'description' => '描述', 'price' => 10.99];
        $this->response->setProduct($data);
        $this->assertEquals($data, $this->response->toArray());
    }

    public function testHandleEmptyProduct()
    {
        $this->assertEquals(null, $this->response->toArray());
    }
}
