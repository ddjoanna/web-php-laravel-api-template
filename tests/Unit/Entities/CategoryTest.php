<?php

namespace Tests\Unit\Entities;

use App\Entities\Category;
use App\Entities\Props\CategoryProps;
use App\Exceptions\ValidationException;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // 設定預設最大層級上限為 3
        config(['app.custom.category_layer_max_limit' => 3]);
    }

    public function testValidateLayerWithParentSuccess(): void
    {
        $parentProps = new CategoryProps('父層', null, 1, 1, true);
        $childProps = new CategoryProps('子層', 1, 2, 1, true);

        $parent = new Category(1, $parentProps);
        $child = new Category(2, $childProps);

        $child->validateLayerWithParent($parent);

        $this->assertTrue(true); // 沒拋例外即通過
    }

    public function testValidateLayerWithParentFail(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        $parentProps = new CategoryProps('父層', 1, 1, 1, true);
        $childProps = new CategoryProps('子層', 3, 1, 1, true); // 錯誤層級

        $parent = new Category(1, $parentProps);
        $child = new Category(2, $childProps);

        $child->validateLayerWithParent($parent);
    }

    public function testValidateLayerWithMaxLimitSuccess(): void
    {
        $props = new CategoryProps('測試', 3, 1, 1, true); // 等於上限 3
        $category = new Category(1, $props);

        $category->validateLayerWithMaxLimit();

        $this->assertTrue(true); // 沒拋例外即通過
    }

    public function testValidateLayerWithMaxLimitFail(): void
    {
        $this->expectException(ValidationException::class);
        $this->expectExceptionMessage('Validation failed');

        $props = new CategoryProps('測試', 1, 5, 1, true); // 層級超過上限
        $category = new Category(1, $props);

        $category->validateLayerWithMaxLimit();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
