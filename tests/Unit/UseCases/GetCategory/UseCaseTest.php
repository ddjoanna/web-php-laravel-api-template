<?php

namespace Tests\Unit\UseCases\GetCategory;

use App\UseCases\GetCategory\Request;
use App\UseCases\GetCategory\Response;
use App\UseCases\GetCategory\UseCase;
use App\Services\CategoryService;
use App\Entities\Category as CategoryEntity;
use App\Entities\Props\CategoryProps;
use Mockery;
use Tests\TestCase;
use App\Exceptions\NotFoundException;

class UseCaseTest extends TestCase
{
    protected $serviceMock;
    protected UseCase $useCase;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock CategoryService
        $this->serviceMock = Mockery::mock(CategoryService::class);

        // Create UseCase instance with mock service
        $this->useCase = new UseCase($this->serviceMock);
    }

    // 測試取得產品成功
    public function testExecuteSuccess()
    {
        $categoryId = 1;

        // Mock CategoryProps
        $categoryPropsMock = Mockery::mock(CategoryProps::class);
        $categoryPropsMock->shouldReceive('getName')->andReturn('Test Category');
        $categoryPropsMock->shouldReceive('getParentId')->andReturn(null);
        $categoryPropsMock->shouldReceive('getLayer')->andReturn(1);
        $categoryPropsMock->shouldReceive('getSortOrder')->andReturn(1);
        $categoryPropsMock->shouldReceive('getIsActive')->andReturn(true);

        // Mock CategoryEntity
        $categoryEntityMock = Mockery::mock(CategoryEntity::class);
        $categoryEntityMock->shouldReceive('getId')->andReturn($categoryId);
        $categoryEntityMock->shouldReceive('getProps')->andReturn($categoryPropsMock);
        $categoryEntityMock->shouldReceive('getChildren')->andReturn(null);

        // Mock find method of CategoryService
        $this->serviceMock
            ->shouldReceive('find')
            ->once()
            ->with($categoryId)
            ->andReturn($categoryEntityMock);

        $request = new Request();
        $request->merge(['id' => $categoryId]);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertEquals([
            "id" => $categoryId,
            "name" => "Test Category",
            "parent_id" => null,
            "layer" => 1,
            "sort_order" => 1,
            "is_active" => true,
        ], $response->toArray());
    }

    // 測試取得產品失敗
    public function testExecuteFailure()
    {
        $categoryId = 1;

        // Mock find method of CategoryService
        $this->serviceMock
            ->shouldReceive('find')
            ->once()
            ->with($categoryId)
            ->andReturn(null);

        $request = new Request();
        $request->merge(['id' => $categoryId]);

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Category not found');

        $this->useCase->execute($request);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
