<?php

namespace Tests\Unit\Repositories;

use App\Repositories\CategoryRepository;
use App\ValueObjects\CategoryValueObject;
use App\Entities\Category as CategoryEntity;
use App\Builders\ConditionsQueryBuilder;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CategoryRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private CategoryRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = app(CategoryRepository::class);
    }

    public function testCreate()
    {
        $valueObject = new CategoryValueObject(
            'Test Category',
            null,
            1,
            1,
            true
        );

        $categoryEntity = $this->repository->create($valueObject);

        $this->assertInstanceOf(CategoryEntity::class, $categoryEntity);
        $this->assertNotNull($categoryEntity->getId());
    }

    public function testFind()
    {
        $category = Category::factory()->create();

        $entity = $this->repository->find($category->id);

        $this->assertInstanceOf(CategoryEntity::class, $entity);
        $this->assertEquals($category->name, $entity->getProps()->getName());
        $this->assertEquals($category->parent_id, $entity->getProps()->getParentId());
        $this->assertEquals($category->layer, $entity->getProps()->getLayer());
        $this->assertEquals($category->sort_order, $entity->getProps()->getSortOrder());
        $this->assertEquals($category->is_active, $entity->getProps()->getIsActive());
    }

    public function testUpdate()
    {
        $category = Category::factory()->create();

        $entity = $this->repository->find($category->id);
        $productProps = $entity->getProps();
        $productProps->setName('Updated Product');

        $updated = $this->repository->update($entity);
        $this->assertTrue($updated);

        $category = $this->repository->find($category->id);
        $this->assertEquals('Updated Product', $category->getProps()->getName());
    }

    public function testDelete()
    {
        $category = Category::factory()->create();

        $deleted = $this->repository->delete($category->id);

        $this->assertTrue($deleted);
        $this->assertNull($this->repository->find($category->id));
    }

    public function testList()
    {
        $this->repository->create(new CategoryValueObject('A', null, 1, 1, true));
        $this->repository->create(new CategoryValueObject('B', null, 1, 2, true));

        $builder = new ConditionsQueryBuilder();
        $list = $this->repository->list($builder);

        $this->assertIsArray($list);
        $this->assertGreaterThanOrEqual(2, count($list));

        foreach ($list as $item) {
            $this->assertInstanceOf(CategoryEntity::class, $item);
        }
    }
}
