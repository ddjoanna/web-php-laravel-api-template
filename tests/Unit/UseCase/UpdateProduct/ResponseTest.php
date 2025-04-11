<?php

namespace Tests\Unit\UseCases\UpdateProduct;

use PHPUnit\Framework\TestCase;
use App\Interfaces\ApiResponse;
use App\UseCases\UpdateProduct\Response;

class ResponseTest extends TestCase
{
    /** @var ApiResponse */
    protected $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = new Response();
    }

    public function testSetStatus()
    {
        $this->response->setStatus('success');
        $this->assertEquals('success', $this->response->toArray()['status']);
    }

    public function testSetMessage()
    {
        $this->response->setMessage('產品取得成功');
        $this->assertEquals('產品取得成功', $this->response->toArray()['message']);
    }

    public function testSetData()
    {
        $data = ['id' => 1, 'title' => '產品標題'];
        $this->response->setData($data);
        $this->assertEquals($data, $this->response->toArray()['data']);
    }

    public function testToArray()
    {
        $this->response->setStatus('success');
        $this->response->setMessage('產品取得成功');
        $this->response->setData(['id' => 1]);

        $expected = [
            'status' => 'success',
            'message' => '產品取得成功',
            'data' => ['id' => 1],
        ];

        $this->assertEquals($expected, $this->response->toArray());
    }

    public function testHandleEmptyStatus()
    {
        $this->assertEquals(null, $this->response->toArray()['message']);
    }

    public function testHandleEmptyMessage()
    {
        $this->assertEquals(null, $this->response->toArray()['message']);
    }

    public function testHandleEmptyData()
    {
        $this->assertEquals(null, $this->response->toArray()['data']);
    }
}
