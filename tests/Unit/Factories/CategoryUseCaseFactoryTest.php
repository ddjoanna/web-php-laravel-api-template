<?php

namespace Tests\Unit\Factories;

use App\Factories\CategoryUseCaseFactory;
use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use App\UseCases\CreateCategory\UseCase as CreateCategoryUseCase;
use App\UseCases\UpdateCategory\UseCase as UpdateCategoryUseCase;
use App\UseCases\DeleteCategory\UseCase as DeleteCategoryUseCase;
use App\UseCases\GetCategory\UseCase as GetCategoryUseCase;
use App\UseCases\ListCategories\UseCase as ListCategoriesUseCase;
use PHPUnit\Framework\TestCase;

class CategoryUseCaseFactoryTest extends TestCase
{
    protected CategoryRepository $repository;
    protected CategoryService $service;
    protected CategoryUseCaseFactory $factory;

    protected function setUp(): void
    {
        parent::setUp();

        // Mock
        $this->repository = $this->createMock(CategoryRepository::class);
        $this->service = $this->createMock(CategoryService::class);

        // 創建 factory 實例
        $this->factory = new CategoryUseCaseFactory($this->repository, $this->service);
    }

    public function testMakeCreateCategoryUseCase()
    {
        $useCase = $this->factory->makeCreateCategoryUseCase();

        $this->assertInstanceOf(CreateCategoryUseCase::class, $useCase);
    }

    public function testMakeUpdateCategoryUseCase()
    {
        $useCase = $this->factory->makeUpdateCategoryUseCase();

        $this->assertInstanceOf(UpdateCategoryUseCase::class, $useCase);
    }

    public function testMakeDeleteCategoryUseCase()
    {
        $useCase = $this->factory->makeDeleteCategoryUseCase();

        $this->assertInstanceOf(DeleteCategoryUseCase::class, $useCase);
    }

    public function testMakeGetCategoryUseCase()
    {
        $useCase = $this->factory->makeGetCategoryUseCase();

        $this->assertInstanceOf(GetCategoryUseCase::class, $useCase);
    }

    public function testMakeListCategoriesUseCase()
    {
        $useCase = $this->factory->makeListCategoriesUseCase();

        $this->assertInstanceOf(ListCategoriesUseCase::class, $useCase);
    }
}
