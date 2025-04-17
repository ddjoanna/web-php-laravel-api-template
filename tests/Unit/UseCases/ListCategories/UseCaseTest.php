<?php

namespace Tests\Unit\UseCases\ListCategories;

use App\UseCases\ListCategories\Request;
use App\UseCases\ListCategories\Response;
use App\UseCases\ListCategories\UseCase;
use App\Services\CategoryService;
use App\Entities\Category as CategoryEntity;
use App\Entities\Props\CategoryProps;
use Mockery;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UseCaseTest extends TestCase
{
    use RefreshDatabase;

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

    // 測試列出產品成功
    public function testExecuteSuccess()
    {
        $request = new Request();
        $request->merge([
            'name' => 'Test',
            'layer' => null,
        ]);

        // Mock CategoryProps
        $productPropsMock = Mockery::mock(CategoryProps::class);
        $productPropsMock->shouldReceive('getName')->andReturn('Test Category');
        $productPropsMock->shouldReceive('getParentId')->andReturn(null);
        $productPropsMock->shouldReceive('getLayer')->andReturn(1);
        $productPropsMock->shouldReceive('getSortOrder')->andReturn(1);
        $productPropsMock->shouldReceive('getIsActive')->andReturn(true);

        // Mock CategoryEntity
        $productEntityMock = Mockery::mock(CategoryEntity::class);
        $productEntityMock->shouldReceive('getId')->andReturn(1);
        $productEntityMock->shouldReceive('getProps')->andReturn($productPropsMock);
        $productEntityMock->shouldReceive('getChildren')->andReturn(null);

        $result = [
            $productEntityMock
        ];
        $this->serviceMock
            ->shouldReceive('list')
            ->once()
            ->andReturn($result);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertCount(1, $response->toArray());
        $this->assertEquals(1, $response->toArray()[0]['id']);
        $this->assertEquals('Test Category', $response->toArray()[0]['name']);
        $this->assertEquals(null, $response->toArray()[0]['parent_id']);
        $this->assertEquals(1, $response->toArray()[0]['layer']);
        $this->assertEquals(1, $response->toArray()[0]['sort_order']);
        $this->assertEquals(true, $response->toArray()[0]['is_active']);
    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
    }
}
