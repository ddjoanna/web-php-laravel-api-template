<?php

namespace Tests\Unit\UseCases\UpdateCategory;

use App\UseCases\UpdateCategory\Request;
use App\UseCases\UpdateCategory\UseCase;
use App\Services\CategoryService;
use Mockery;
use Tests\TestCase;

class UseCaseTest extends TestCase
{
    protected UseCase $useCase;
    protected $serviceMock;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock CategoryService
        $this->serviceMock = Mockery::mock(CategoryService::class);

        // Create UseCase instance with mock service
        $this->useCase = new UseCase($this->serviceMock);
    }

    // 測試更新產品成功
    public function testExecuteSuccess()
    {
        $request = new Request();
        $request->merge([
            'id' => 1,
            'name' => 'Test Category',
            'parent_id' => 1,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        // Mock update method of CategoryService
        $this->serviceMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(true);

        $updated = $this->useCase->execute($request);

        $this->assertTrue($updated);
    }

    // 測試更新產品失敗
    public function testExecuteFailure()
    {
        $request = new Request();
        $request->merge([
            'id' => 1,
            'name' => 'Test Category',
            'parent_id' => 1,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        // Mock update method of CategoryService
        $this->serviceMock
            ->shouldReceive('update')
            ->once()
            ->andReturn(false);

        $updated = $this->useCase->execute($request);

        $this->assertFalse($updated);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
