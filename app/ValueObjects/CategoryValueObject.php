<?php

namespace App\ValueObjects;

use App\Exceptions\ValidationException;

final class CategoryValueObject
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
        bool $is_active
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

    public function getParentId(): ?int
    {
        return $this->parent_id;
    }

    public function getLayer(): int
    {
        return $this->layer;
    }

    public function getSortOrder(): int
    {
        return $this->sort_order;
    }

    public function getIsActive(): bool
    {
        return $this->is_active;
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'layer' => $this->layer,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];
    }

    public function validateLayerWithMaxLimit(): void
    {
        $layer = $this->getLayer();
        $layer_max_limit = config('app.custom.category_layer_max_limit');
        if ($layer > $layer_max_limit) {
            $ex = new ValidationException('Validation failed');
            $ex->addError(
                'layer',
                ['層級 必須小於或等於 ' . $layer_max_limit . '。']
            );
            throw $ex;
        }
    }
}
