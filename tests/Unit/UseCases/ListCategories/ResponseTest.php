<?php

namespace Tests\Unit\UseCases\ListCategories;

use PHPUnit\Framework\TestCase;
use App\UseCases\ListCategories\Response;
use App\Entities\Category;
use App\Entities\Props\CategoryProps;

class ResponseTest extends TestCase
{
    protected Response $response;

    protected function setUp(): void
    {
        parent::setUp();
        $this->response = new Response();
    }

    public function testToArray()
    {
        $expected = [
            [
                'id' => 1,
                'name' => '標題1',
                'parent_id' => null,
                'layer' => 1,
                'sort_order' => 1,
                'is_active' => true
            ],
            [
                'id' => 2,
                'name' => '標題2',
                'parent_id' => null,
                'layer' => 1,
                'sort_order' => 2,
                'is_active' => true
            ],
        ];

        $entity = [];
        foreach ($expected as $category) {
            $entity[] = new Category($category['id'], new CategoryProps(
                $category['name'],
                $category['parent_id'],
                $category['layer'],
                $category['sort_order'],
                $category['is_active']
            ));
        }
        $this->response->setCategories($entity);

        $this->assertEquals($expected, $this->response->toArray());
    }

    public function testHandleEmptyData()
    {
        $this->assertEquals([], $this->response->toArray());
    }
}
