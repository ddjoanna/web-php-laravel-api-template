<?php

namespace App\Repositories;

use App\Models\Product;
use App\Builders\ConditionsQueryBuilder;
use App\Entities\Product as ProductEntity;
use App\ValueObjects\ProductValueObject;
use App\Factories\ProductFactory;

class ProductRepository
{
    public function create(ProductValueObject $productVO): ProductEntity
    {
        $product = Product::create($productVO->getProduct());
        return ProductFactory::create($product->toArray());
    }

    public function find($id): ?ProductEntity
    {
        $product = Product::find($id);
        return $product ? ProductFactory::create($product->toArray()) : null;
    }

    public function update(ProductEntity $productEntity): bool
    {
        $product = Product::find($productEntity->getId());
        if (!$product) {
            return false;
        }

        return $product->update([
            'name' => $productEntity->getProps()->getName(),
            'description' => $productEntity->getProps()->getDescription(),
            'price' => $productEntity->getProps()->getPrice(),
        ]);
    }


    public function delete($id): bool
    {
        $product = Product::find($id);
        if (!$product) {
            return false;
        }
        return $product->delete();
    }

    public function list(ConditionsQueryBuilder $conditionsQueryBuilder): array
    {
        $query = Product::query();
        $query = $conditionsQueryBuilder->build($query);
        $products = $query->get()->toArray();

        return ProductFactory::bulk($products);
    }

    public function paginate(ConditionsQueryBuilder $conditionsQueryBuilder): array
    {
        $query = Product::query();
        $query = $conditionsQueryBuilder->build($query);

        $paginator = $query->paginate(
            $conditionsQueryBuilder->getPageSize(),
            $conditionsQueryBuilder->getColumns(),
            'page',
            $conditionsQueryBuilder->getPage()
        )->toArray();

        $products = ProductFactory::bulk($paginator['data']);

        return [
            'products' => $products,
            'pagination' => [
                'page' => $paginator['current_page'],
                'page_size' => $paginator['per_page'],
                'total' => $paginator['total'],
                'order_by' => $conditionsQueryBuilder->getOrderBy(),
                'order_direction' => $conditionsQueryBuilder->getOrderDirection(),
            ]
        ];
    }
}
