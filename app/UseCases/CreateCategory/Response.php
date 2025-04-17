<?php

namespace App\UseCases\CreateCategory;

use App\Entities\Category;

class Response
{
    protected ?array $category = null;

    public function setCategory(Category $category): void
    {
        $props = $category->getProps();
        $this->category = [
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
