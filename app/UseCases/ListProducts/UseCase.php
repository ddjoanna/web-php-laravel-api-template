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

        if ($request->input('keyword')) {
            $conditionsQueryBuilder->where('name', '=', $request->input('keyword'));
            $conditionsQueryBuilder->where('description', '=', $request->input('keyword'));
        }

        $result = $this->service->fetchPaginatedData($conditionsQueryBuilder);

        $response = new Response();
        $response->setStatus('success');
        $response->setMessage('取得成功');
        $products = array_map(function ($product) {
            return [
                'id' => $product->getId(),
                'name' => $product->getProps()->getName(),
                'description' => $product->getProps()->getDescription(),
                'price' => $product->getProps()->getPrice(),
            ];
        }, $result['products'], []);
        $response->setData($products);
        $response->setPagination($result['pagination'] ?? null);

        return $response;
    }
}
