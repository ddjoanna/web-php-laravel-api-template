<?php

namespace Tests\Unit\UseCases\ListProducts;

use PHPUnit\Framework\TestCase;
use App\Interfaces\ApiResponse;
use App\UseCases\ListProducts\Response;

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
        $this->response->setMessage('取得成功');
        $this->assertEquals('取得成功', $this->response->toArray()['message']);
    }

    public function testSetData()
    {
        $data = [
            ['id' => 1, 'title' => '標題1', 'description' => '描述1', 'price' => 10.99],
            ['id' => 2, 'title' => '標題2', 'description' => '描述2', 'price' => 10.99],
        ];
        $this->response->setData($data);
        $this->assertEquals([
            'products' => $data,
            'pagination' => null,
        ], $this->response->toArray()['data']);
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
        ], $this->response->toArray()['data']);
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

        $this->response->setStatus('success');
        $this->response->setMessage('取得成功');
        $this->response->setData($data);
        $this->response->setPagination($pagination);

        $expected = [
            'status' => 'success',
            'message' => '取得成功',
            'data' => [
                'products' => $data,
                'pagination' => $pagination,
            ],
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
        $this->assertEquals([
            'products' => null,
            'pagination' => null,
        ], $this->response->toArray()['data']);
    }
}
