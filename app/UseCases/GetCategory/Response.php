<?php

namespace App\UseCases\GetCategory;

use App\Entities\Category;

class Response
{
    protected ?array $category = null;

    public function setCategory(Category $category): void
    {
        $this->category = $this->convertCategoryWithEntity($category);
        if ($category->getChildren()) {
            $this->category['children'] = array_map(function ($child) {
                return $this->convertCategoryWithEntity($child);
            }, $category->getChildren(), []);
        }
    }

    private function convertCategoryWithEntity(Category $category): array
    {
        $props = $category->getProps();
        return [
            'id' => $category->getId(),
            'name' => $props->getName(),
            'parent_id' => $props->getParentId(),
            'layer' => $props->getLayer(),
            'sort_order' => $props->getSortOrder(),
            'is_active' => $props->getIsActive(),
        ];
    }

    public function toArray(): ?array
    {
        return $this->category;
    }
}
