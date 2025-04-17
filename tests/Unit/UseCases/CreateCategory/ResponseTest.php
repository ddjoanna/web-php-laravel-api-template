<?php

namespace Tests\Unit\UseCases\CreateCategory;

use Tests\TestCase;
use App\UseCases\CreateCategory\Response;
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

    public function testSetCategory()
    {
        $data = [
            'id' => 1,
            'name' => '標題',
            'parent_id' => 1,
            'layer' => 1,
            'sort_order' => 1,
            'is_active' => true,
        ];
        $categoryEntity = new Category(1, new CategoryProps(
            $data['name'],
            $data['parent_id'],
            $data['layer'],
            $data['sort_order'],
            $data['is_active']
        ));
        $this->response->setCategory($categoryEntity);
        $this->assertEquals($data, $this->response->toArray());
    }

    public function testHandleEmptyCategory()
    {
        $this->assertEquals(null, $this->response->toArray());
    }
}
