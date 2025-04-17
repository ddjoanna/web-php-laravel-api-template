<?php

namespace App\UseCases\UpdateCategory;

use App\UseCases\UpdateCategory\Request;
use App\Services\CategoryService;
use App\Factories\CategoryFactory;

class UseCase
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): bool
    {
        $category = CategoryFactory::create($request->all());
        return $this->service->update($category);
    }
}
