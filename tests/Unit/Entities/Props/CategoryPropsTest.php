<?php

namespace Tests\Unit\Entities\Props;

use App\Entities\Props\CategoryProps;
use Tests\TestCase;

class CategoryPropsTest extends TestCase
{
    protected string $name;
    protected ?int $parent_id;
    protected int $layer;
    protected int $sort_order;
    protected bool $is_active;
    private CategoryProps $props;

    protected function setUp(): void
    {
        parent::setUp();

        $this->name = 'Test Category';
        $this->parent_id = null;
        $this->layer = 1;
        $this->sort_order = 1;
        $this->is_active = true;

        $this->props = new CategoryProps(
            $this->name,
            $this->parent_id,
            $this->layer,
            $this->sort_order,
            $this->is_active
        );
    }

    /**
     * 測試建構子
     */
    public function testConstructor()
    {
        $this->assertEquals($this->name, $this->props->getName());
        $this->assertEquals($this->parent_id, $this->props->getParentId());
        $this->assertEquals($this->layer, $this->props->getLayer());
        $this->assertEquals($this->sort_order, $this->props->getSortOrder());
        $this->assertEquals($this->is_active, $this->props->getIsActive());
    }

    public function testSetName()
    {
        $new_name = 'Updated Name';

        $this->props->setName($new_name);

        $this->assertEquals($new_name, $this->props->getName());
    }

    public function testSetPartent()
    {
        $new_parent_id = 123;

        $this->props->setParentId($new_parent_id);

        $this->assertEquals($new_parent_id, $this->props->getParentId());
    }

    public function testSetLayer()
    {
        $new_layer = 2;

        $this->props->setLayer($new_layer);

        $this->assertEquals($new_layer, $this->props->getLayer());
    }

    public function testSetSortOrder()
    {
        $new_sort_order = 2;

        $this->props->setSortOrder($new_sort_order);

        $this->assertEquals($new_sort_order, $this->props->getSortOrder());
    }

    public function testSetIsActive()
    {
        $new_is_active = false;

        $this->props->setIsActive($new_is_active);

        $this->assertEquals($new_is_active, $this->props->getIsActive());
    }

    public function testGetCategory()
    {
        $expectedResult = [
            'name' => $this->name,
            'parent_id' => $this->parent_id,
            'layer' => $this->layer,
            'sort_order' => $this->sort_order,
            'is_active' => $this->is_active,
        ];

        $this->assertEquals($expectedResult, $this->props->getCategory());
    }
}
