<?php

namespace App\UseCases\CreateCategory;

use App\UseCases\CreateCategory\Request;
use App\UseCases\CreateCategory\Response;
use App\Services\CategoryService;

class UseCase
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $categoryVo = new \App\ValueObjects\CategoryValueObject(
            $request->input('name'),
            $request->input('parent_id'),
            $request->input('layer'),
            $request->input('sort_order'),
            $request->input('is_active')
        );

        $category = $this->service->create($categoryVo);

        $response = new Response();
        $response->setCategory($category);

        return $response;
    }
}
