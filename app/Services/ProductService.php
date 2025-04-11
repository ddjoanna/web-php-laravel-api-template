<?php

namespace App\Services;

use App\Repositories\ProductRepository;
use App\ValueObjects\ProductValueObject;
use App\Entities\Product as ProductEntity;
use App\Builders\ConditionsQueryBuilder;

class ProductService
{
    protected ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function create(ProductValueObject $productVO): ProductEntity
    {
        return $this->productRepository->create($productVO);
    }

    public function find(int $id): ?ProductEntity
    {
        return $this->productRepository->find($id);
    }

    public function update(ProductEntity $product): bool
    {
        return $this->productRepository->update($product);
    }

    public function delete(int $id): bool
    {
        return $this->productRepository->delete($id);
    }

    public function list(ConditionsQueryBuilder $conditionsQueryBuilder): array
    {
        return $this->productRepository->list($conditionsQueryBuilder);
    }

    public function fetchPaginatedData(ConditionsQueryBuilder $conditionsQueryBuilder): array
    {
        return $this->productRepository->paginate($conditionsQueryBuilder);
    }
}
