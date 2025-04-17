<?php

namespace App\UseCases\ListProducts;

use App\UseCases\ListProducts\Request;
use App\UseCases\ListProducts\Response;
use App\Services\ProductService;
use App\Builders\ConditionsQueryBuilder;

class UseCase
{
    protected ProductService $service;

    public function __construct(ProductService $service)
    {
        $this->service = $service;
    }

    public function execute(Request $request): Response
    {
        $conditionsQueryBuilder = new ConditionsQueryBuilder();
        $conditionsQueryBuilder
            ->setPage($request->input('page', 1))
            ->setPageSize($request->input('page_size', 10))
            ->setOrderBy($request->input('order_by', 'created_at'))
            ->setOrderDirection($request->input('order_direction', 'desc'));

        if ($request->input('name')) {
            $conditionsQueryBuilder->like('name', $request->input('name'));
        }

        if ($request->input('description')) {
            $conditionsQueryBuilder->like('description', $request->input('description'));
        }

        $result = $this->service->fetchPaginatedData($conditionsQueryBuilder);

        $response = new Response();
        $response->setProducts($result['products'] ?? []);
        $response->setPagination($result['pagination'] ?? []);

        return $response;
    }
}
