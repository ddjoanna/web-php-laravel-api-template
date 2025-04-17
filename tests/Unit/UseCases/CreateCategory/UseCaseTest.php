<?php

namespace Tests\Unit\UseCases\CreateCategory;

use App\UseCases\CreateCategory\Request;
use App\UseCases\CreateCategory\Response;
use App\UseCases\CreateCategory\UseCase;
use App\Services\CategoryService;
use App\ValueObjects\CategoryValueObject;
use App\Entities\Category as CategoryEntity;
use App\Entities\Props\CategoryProps;
use Tests\TestCase;
use Mockery;

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

    public function testExecute()
    {
        $request = new Request();
        $request->merge([
            'name' => 'Test Category',
            'parent_id' => null,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $categoryPropsMock = Mockery::mock(CategoryProps::class);
        $categoryPropsMock->shouldReceive('getName')->andReturn('Test Category');
        $categoryPropsMock->shouldReceive('getParentId')->andReturn(null);
        $categoryPropsMock->shouldReceive('getLayer')->andReturn(1);
        $categoryPropsMock->shouldReceive('getSortOrder')->andReturn(1);
        $categoryPropsMock->shouldReceive('getIsActive')->andReturn(true);

        $categoryEntityMock = Mockery::mock(CategoryEntity::class);
        $categoryEntityMock->shouldReceive('getId')->andReturn(1);
        $categoryEntityMock->shouldReceive('getProps')->andReturn($categoryPropsMock);

        $this->serviceMock->shouldReceive('create')
            ->once()
            ->with(Mockery::on(function ($arg) {
                return $arg instanceof CategoryValueObject &&
                    $arg->getName() === 'Test Category';
                $arg->getParentId() === null &&
                    $arg->getLayer() === 1 &&
                    $arg->getSortOrder() === 1 &&
                    $arg->getIsActive() === true;
            }))
            ->andReturn($categoryEntityMock);

        $response = $this->useCase->execute($request);

        $this->assertInstanceOf(Response::class, $response);
        $this->assertIsArray($response->toArray());
        $this->assertEquals([
            "id" => 1,
            "name" => "Test Category",
            "parent_id" => null,
            "layer" => 1,
            "sort_order" => 1,
            "is_active" => true,
        ], $response->toArray());
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}
