<?php

namespace Tests\Unit\UseCases\CreateProduct;

use PHPUnit\Framework\TestCase;
use App\Interfaces\ApiResponse;
use App\UseCases\CreateProduct\Response;

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
        $this->response->setMessage('創建成功');
        $this->assertEquals('創建成功', $this->response->toArray()['message']);
    }

    public function testSetData()
    {
        $data = ['id' => 1, 'title' => '標題', 'description' => '描述', 'price' => 10.99];
        $this->response->setData($data);
        $this->assertEquals($data, $this->response->toArray()['data']);
    }

    public function testToArray()
    {
        $data = ['id' => 1, 'title' => '標題', 'description' => '描述', 'price' => 10.99];
        $this->response->setStatus('success');
        $this->response->setMessage('創建成功');
        $this->response->setData($data);

        $expected = [
            'status' => 'success',
            'message' => '創建成功',
            'data' => $data,
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
