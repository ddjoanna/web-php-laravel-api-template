<?php

namespace App\UseCases\ListCategories;

use App\UseCases\ListCategories\Request;
use App\UseCases\ListCategories\Response;
use App\Services\CategoryService;
use App\Builders\ConditionsQueryBuilder;

class UseCase
{
    protected CategoryService $service;

    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $conditionsQueryBuilder = new ConditionsQueryBuilder();
        $conditionsQueryBuilder
            ->setOrderBy('sort_order')
            ->setOrderDirection('asc');

        if ($request->input('layer')) {
            $conditionsQueryBuilder->where('layer', $request->input('layer'));
        }

        if ($request->input('name')) {
            $conditionsQueryBuilder->like('name', $request->input('name'));
        }

        if (!$request->input('parent_id') && !$request->input('layer')) {
            $conditionsQueryBuilder->where('layer', 1);
        }

        $categories = $this->service->list($conditionsQueryBuilder);

        $response = new Response();
        $response->setCategories($categories);

        return $response;
    }
}
