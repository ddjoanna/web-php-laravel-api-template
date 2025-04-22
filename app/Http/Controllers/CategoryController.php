<?php

namespace App\Http\Controllers;

use App\Factories\CategoryUseCaseFactory;
use App\UseCases\CreateCategory;
use App\UseCases\GetCategory;
use App\UseCases\ListCategories;
use App\UseCases\UpdateCategory;
use App\UseCases\DeleteCategory;
use App\Services\ApiResponseService;
use Illuminate\Http\JsonResponse;

class CategoryController extends Controller
{
    protected CategoryUseCaseFactory $CategoryUseCaseFactory;

    public function __construct(CategoryUseCaseFactory $CategoryUseCaseFactory)
    {
        $this->CategoryUseCaseFactory = $CategoryUseCaseFactory;
    }

    public function index(ListCategories\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->CategoryUseCaseFactory->makeListCategoriesUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    public function store(CreateCategory\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->CategoryUseCaseFactory->makeCreateCategoryUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    public function show(GetCategory\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->CategoryUseCaseFactory->makeGetCategoryUseCase();
        $result = $usecase->execute($request);
        return $response->success(200, 'success', $result->toArray());
    }

    public function update(UpdateCategory\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->CategoryUseCaseFactory->makeUpdateCategoryUseCase();
        $usecase->execute($request);
        return $response->success(204, 'success', null);
    }

    public function destroy(DeleteCategory\Request $request, ApiResponseService $response): JsonResponse
    {
        $usecase = $this->CategoryUseCaseFactory->makeDeleteCategoryUseCase();
        $usecase->execute($request);
        return $response->success(204, 'success', null);
    }
}
