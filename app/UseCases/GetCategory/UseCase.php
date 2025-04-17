<?php

namespace App\UseCases\GetCategory;

use App\UseCases\GetCategory\Request;
use App\UseCases\GetCategory\Response;
use App\Services\CategoryService;
use App\Exceptions\NotFoundException;

class UseCase
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $category = $this->service->find($request->input('id'));
        if (!$category) {
            throw new NotFoundException('Category not found');
        }

        $response = new Response();
        $response->setCategory($category);

        return $response;
    }
}
