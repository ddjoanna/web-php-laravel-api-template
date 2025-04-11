<?php

namespace Tests\Unit\UseCases\DeleteProduct;

use App\UseCases\DeleteProduct\Request;
use App\UseCases\DeleteProduct\Response;
use App\UseCases\DeleteProduct\UseCase;
use App\Services\ProductService;
use Mockery;
use Tests\TestCase;

class UseCaseTest extends TestCase
{
    protected UseCase $useCase;
    protected $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock ProductService
        $this->serviceMock = Mockery::mock(ProductService::class);

        // Create UseCase instance with mock service
        $this->useCase = new UseCase($this->serviceMock);
    }

    /**
     * 測試刪除產品成功
     */
    public function testExecuteSuccess()
    {
        $request = new Request();
        $request->merge(['id' => 1]);

        // Mock find method of ProductService
        $this->serviceMock
            ->shouldReceive('delete')
            ->once()
            ->with($request->input('id'))
            ->andReturn(true);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals([
            'status' => 'success',
            'message' => '刪除成功',
            'data' => null,
        ], $response->toArray());
    }

    /**
     * 測試刪除產品失敗
     */
    public function testExecuteFailure()
    {
        $request = new Request();
        $request->merge(['id' => 1]);

        // Mock find method of ProductService
        $this->serviceMock
            ->shouldReceive('delete')
            ->once()
            ->with($request->input('id'))
            ->andReturn(false);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals([
            'status' => 'failed',
            'message' => '刪除失敗',
            'data' => null,
        ], $response->toArray());
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
