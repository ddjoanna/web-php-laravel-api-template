<?php

namespace App\UseCases\DeleteCategory;

use App\UseCases\DeleteCategory\Request;
use App\Services\CategoryService;

class UseCase
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): bool
    {
        return $this->service->delete($request->input('id'));
    }
}
