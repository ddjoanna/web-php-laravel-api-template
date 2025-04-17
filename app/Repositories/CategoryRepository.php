<?php

namespace App\Repositories;

use App\Models\Category;
use App\Builders\ConditionsQueryBuilder;
use App\Entities\Category as CategoryEntity;
use App\ValueObjects\CategoryValueObject;
use App\Factories\CategoryFactory;

class CategoryRepository
{
    public function create(CategoryValueObject $categoryVO): CategoryEntity
    {
        $category = Category::create($categoryVO->toArray());
        return CategoryFactory::create($category->toArray());
    }

    public function find($id): ?CategoryEntity
    {
        $category = Category::find($id);
        return $category ? CategoryFactory::create($category->toArray()) : null;
    }

    public function update(CategoryEntity $entity): bool
    {
        $category = Category::find($entity->getId());
        if (!$category) {
            return false;
        }

        return $category->update([
            'name' => $entity->getProps()->getName(),
            'parent_id' => $entity->getProps()->getParentId(),
            'layer' => $entity->getProps()->getLayer(),
            'sort_order' => $entity->getProps()->getSortOrder(),
            'is_active' => $entity->getProps()->getIsActive(),
        ]);
    }

    public function delete($id): bool
    {
        $category = Category::find($id);
        if (!$category) {
            return false;
        }
        return $category->delete();
    }

    public function list(ConditionsQueryBuilder $conditionsQueryBuilder): array
    {
        $layer_max_limit = config('app.custom.category_layer_max_limit');
        $children = "";
        for ($i = 1; $i < $layer_max_limit; $i++) {
            $children .= ($i > 1 ? ".children" : "children");
        }

        $query = Category::query();
        $query = $conditionsQueryBuilder->build($query);
        $paginator = $query->with($children)->paginate(
            $conditionsQueryBuilder->getPageSize(),
            $conditionsQueryBuilder->getColumns(),
            'page',
            $conditionsQueryBuilder->getPage()
        )->toArray();

        return CategoryFactory::bulk($paginator['data']);
    }
}
