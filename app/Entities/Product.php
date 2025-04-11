<?php

namespace App\Entities;

class Product
{
    private int $id;
    private Props\ProductProps $props;

    public function __construct(int $id, Props\ProductProps $props)
    {
        $this->id = $id;
        $this->props = $props;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getProps(): Props\ProductProps
    {
        return $this->props;
    }

    public function setProps(Props\ProductProps $props): void
    {
        $this->props = $props;
    }
}
