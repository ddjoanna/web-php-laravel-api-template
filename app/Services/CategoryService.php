<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use App\ValueObjects\CategoryValueObject;
use App\Entities\Category as CategoryEntity;
use App\Builders\ConditionsQueryBuilder;
use App\Exceptions\ValidationException;

class CategoryService
{
    protected CategoryRepository $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function create(CategoryValueObject $categoryVO): CategoryEntity
    {
        $parent_id = $categoryVO->getParentId();

        if ($parent_id !== null) {
            $parent = $this->find($parent_id);
            if ($parent === null) {
                $ex = new ValidationException('Validation failed');
                $ex->addError(
                    'parent_id',
                    ['所選的 上層分類 ID 無效。']
                );
                throw $ex;
            }
            if ($categoryVO->getLayer() !== ($parent->getProps()->getLayer() + 1)) {
                $ex = new ValidationException('Validation failed');
                $ex->addError(
                    'layer',
                    ['層級 必須等於上層分類的層級+1。']
                );
                throw $ex;
            }
        }

        $categoryVO->validateLayerWithMaxLimit();

        return $this->categoryRepository->create($categoryVO);
    }

    public function find(int $id): ?CategoryEntity
    {
        return $this->categoryRepository->find($id);
    }

    public function update(CategoryEntity $category): bool
    {
        $category->validateLayerWithMaxLimit();

        $parent_id = $category->getProps()->getParentId();

        if ($parent_id !== null) {
            $parent = $this->find($parent_id);
            if ($parent === null) {
                $ex = new ValidationException('Validation failed');
                $ex->addError(
                    'parent_id',
                    ['所選的 上層分類 ID 無效。']
                );
                throw $ex;
            }
            $category->validateLayerWithParent($parent);
        }

        return $this->categoryRepository->update($category);
    }

    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }

    public function list(ConditionsQueryBuilder $conditionsQueryBuilder): array
    {
        return $this->categoryRepository->list($conditionsQueryBuilder);
    }
}
