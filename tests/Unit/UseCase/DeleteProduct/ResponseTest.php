<?php

namespace Tests\Unit\UseCases\DeleteProduct;

use PHPUnit\Framework\TestCase;
use App\Interfaces\ApiResponse;
use App\UseCases\DeleteProduct\Response;

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
        $this->response->setMessage('刪除成功');
        $this->assertEquals('刪除成功', $this->response->toArray()['message']);
    }

    public function testSetData()
    {
        $this->assertEquals(null, $this->response->toArray()['data']);
    }

    public function testToArray()
    {
        $this->response->setStatus('success');
        $this->response->setMessage('刪除成功');

        $expected = [
            'status' => 'success',
            'message' => '刪除成功',
            'data' => null,
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
