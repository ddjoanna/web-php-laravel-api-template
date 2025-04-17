<?php

namespace App\Entities\Props;

class CategoryProps
{
    private string $name;
    private ?int $parent_id;
    private int $layer;
    private int $sort_order;
    private bool $is_active;

    public function __construct(
        string $name,
        ?int $parent_id,
        int $layer,
        int $sort_order,
        bool $is_active,
    ) {
        $this->name = $name;
        $this->parent_id = $parent_id;
        $this->layer = $layer;
        $this->sort_order = $sort_order;
        $this->is_active = $is_active;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function setParentId(?int $parent_id): void
    {
        $this->parent_id = $parent_id;
    }

    public function getLayer(): int
    {
        return $this->layer;
    }

    public function setLayer(int $layer): void
    {
        $this->layer = $layer;
    }

    public function getSortOrder(): int
    {
        return $this->sort_order;
    }

    public function setSortOrder(int $sort_order): void
    {
        $this->sort_order = $sort_order;
    }

    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    public function setIsActive(bool $is_active): void
    {
        $this->is_active = $is_active;
    }

    public function getCategory(): array
    {
        return [
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'layer' => $this->layer,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];
    }
}
