<?php

namespace App\Factories;

use App\Repositories\CategoryRepository;
use App\Services\CategoryService;
use App\UseCases\CreateCategory\UseCase as CreateCategoryUseCase;
use App\UseCases\UpdateCategory\UseCase as UpdateCategoryUseCase;
use App\UseCases\DeleteCategory\UseCase as DeleteCategoryUseCase;
use App\UseCases\GetCategory\UseCase as GetCategoryUseCase;
use App\UseCases\ListCategories\UseCase as ListCategoriesUseCase;

class CategoryUseCaseFactory
{
    protected CategoryRepository $Category_repository;
    protected CategoryService $Category_service;

    public function __construct(CategoryRepository $Category_repository, CategoryService $Category_service)
    {
        $this->Category_repository = $Category_repository;
        $this->Category_service = $Category_service;
    }

    public function makeCreateCategoryUseCase(): CreateCategoryUseCase
    {
        return new CreateCategoryUseCase($this->Category_service);
    }

    public function makeUpdateCategoryUseCase(): UpdateCategoryUseCase
    {
        return new UpdateCategoryUseCase($this->Category_service);
    }

    public function makeDeleteCategoryUseCase(): DeleteCategoryUseCase
    {
        return new DeleteCategoryUseCase($this->Category_service);
    }

    public function makeGetCategoryUseCase(): GetCategoryUseCase
    {
        return new GetCategoryUseCase($this->Category_service);
    }

    public function makeListCategoriesUseCase(): ListCategoriesUseCase
    {
        return new ListCategoriesUseCase($this->Category_service);
    }
}
