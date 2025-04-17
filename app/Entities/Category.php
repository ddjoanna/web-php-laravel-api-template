<?php

namespace App\Entities;

use App\Exceptions\ValidationException;

class Category
{
    private int $id;
    private Props\CategoryProps $props;
    private ?array $children = null;

    public function __construct(int $id, Props\CategoryProps $props)
    {
        $this->id = $id;
        $this->props = $props;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getChildren(): ?array
    {
        return $this->children;
    }

    public function setChildren(array $children): void
    {
        $this->children = $children;
    }


    public function getProps(): Props\CategoryProps
    {
        return $this->props;
    }

    public function setProps(Props\CategoryProps $props): void
    {
        $this->props = $props;
    }

    public function validateLayerWithParent(Category $parent): void
    {
        $layer = $this->props->getLayer();
        $parentLayer = $parent->getProps()->getLayer();

        if ($layer  !== ($parentLayer + 1)) {
            $ex = new ValidationException('Validation failed');
            $ex->addError(
                'layer',
                ['層級 必須等於上層分類的層級+1。']
            );
            throw $ex;
        }
    }

    public function validateLayerWithMaxLimit(): void
    {
        $layer = $this->props->getLayer();
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
