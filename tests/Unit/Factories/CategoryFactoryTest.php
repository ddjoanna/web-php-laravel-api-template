<?php

namespace Tests\Unit\Factories;

use App\Entities\Category;
use App\Factories\CategoryFactory;
use PHPUnit\Framework\TestCase;

class CategoryFactoryTest extends TestCase
{
    public function testCreateCategoryWithoutChildren(): void
    {
        $row = [
            'id' => 1,
            'name' => '主分類',
            'parent_id' => null,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => true,
            'children' => [],
        ];

        $category = CategoryFactory::create($row);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals(1, $category->getId());
        $this->assertEquals('主分類', $category->getProps()->getName());
        $this->assertEquals(null, $category->getProps()->getParentId());
        $this->assertEquals(1, $category->getProps()->getLayer());
        $this->assertEquals(null, $category->getChildren());
    }

    public function testCreateCategoryWithChildren(): void
    {
        $row = [
            'id' => 1,
            'name' => '主分類',
            'parent_id' => null,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => true,
            'children' => [
                [
                    'id' => 2,
                    'name' => '子分類1',
                    'parent_id' => 1,
                    'layer' => 2,
                    'sort_order' => 1,
                    'is_active' => true,
                    'children' => [],
                ],
                [
                    'id' => 3,
                    'name' => '子分類2',
                    'parent_id' => 1,
                    'layer' => 2,
                    'sort_order' => 2,
                    'is_active' => false,
                    'children' => [],
                ],
            ],
        ];

        $category = CategoryFactory::create($row);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertCount(2, $category->getChildren());

        $child1 = $category->getChildren()[0];
        $this->assertEquals('子分類1', $child1->getProps()->getName());
        $this->assertEquals(true, $child1->getProps()->getIsActive());

        $child2 = $category->getChildren()[1];
        $this->assertEquals('子分類2', $child2->getProps()->getName());
        $this->assertEquals(false, $child2->getProps()->getIsActive());
    }
}
