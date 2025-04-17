<?php

namespace App\UseCases\ListCategories;

use App\Entities\Category;

class Response
{
    protected array $categories = [];

    public function setCategories(array $categories): void
    {
        $this->categories = array_map(function (Category $category) {
            return $this->convertCategoryWithChildren($category);
        }, $categories);
    }

    /**
     * 遞迴轉換 Category 及其所有子孫
     */
    private function convertCategoryWithChildren(Category $category): array
    {
        $row = $this->convertCategoryWithEntity($category);

        $children = $category->getChildren();
        if ($children && count($children) > 0) {
            $row['children'] = array_map(function (Category $child) {
                return $this->convertCategoryWithChildren($child);
            }, $children);
        }

        return $row;
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

    public function toArray(): array
    {
        return $this->categories;
    }
}
